# -*- coding: utf-8 -*-
### Main Class ###
# MIT License by @ichii731

import requests
import json
from PIL import Image, ImageOps
import face_recognition
import urllib.request
import io
import tweepy
import os
from dotenv import load_dotenv


class Symmetry:
    upload_list = []
    image_url = ""
    text = ""
    username = ""
    load_dotenv()
    api_url = os.getenv('API_URL')
    CK = os.getenv('CK')
    CS = os.getenv('CS')
    AT = os.getenv('AT')
    AS = os.getenv('AS')

    def __init__(self, _username):
        self.username = _username
        try:
            data = self.request_api()
            for n in data:
                self.main(n)
        except TypeError:
            exit
        else:
            pass

    def main(self, _n):
        self.image_url = _n['image_url']
        self.text = _n['text']
        source = self.url2bin(self.image_url)
        upload_source = self.url2bin(self.image_url)
        upload_source.seek(0)
        self.add_upload_list(upload_source)

        # Face_Recognize!
        response = urllib.request.urlopen(self.image_url)
        image = face_recognition.load_image_file(response)
        face_locations = face_recognition.face_locations(image)

        if len(face_locations) == 0:
            self.text = "画像から顔が認識出来ませんでした. Tweet by @" + self.username + " / " + self.text
            exit
        else:
            self.text = "Tweet by @" + self.username + " / " + self.text
            for i in range(len(face_locations)):
                # Crop&Save
                top, right, bottom, left = face_locations[i]
                sym_pixel = (right + left) // 2
                i = self.sym_crop(sym_pixel, source)
                i.seek(0)
                self.add_upload_list(i)
        # Upload to Twitter
        self.upload_to_twitter()
        del self.upload_list[:]

    ### API Call ###
    def request_api(self):
        url = self.api_url + self.username
        response = requests.get(url)
        jsonData = response.json()
        return jsonData

    def url2bin(self, _url):
        return io.BytesIO(urllib.request.urlopen(_url).read())

    def add_upload_list(self, _bin):
        bin = io.BufferedReader(_bin)
        self.upload_list.append(bin)

    ### Tweet ###
    def upload_to_twitter(self):
        # Authenticate to Twitter
        auth = tweepy.OAuthHandler(self.CK, self.CS)
        auth.set_access_token(self.AT, self.AS)
        api = tweepy.API(auth)
        # Upload images and get media_ids
        media_ids = []
        for file_byte in self.upload_list:
            res = api.media_upload('post.png', file=file_byte)
            media_ids.append(res.media_id)
        # Post tweet
        api.update_status(status=self.text, media_ids=media_ids)

    ### Crop / Save ###
    def sym_crop(self, pixel, f):
        # Crop Left Half
        img = Image.open(f)
        tmp1 = img.crop((0, 0, pixel, img.size[1]))
        tmp2 = ImageOps.mirror(tmp1)
        dst = Image.new('RGB', (tmp1.width + tmp2.width, tmp1.height))
        dst.paste(tmp1, (0, 0))
        dst.paste(tmp2, (tmp1.width, 0))
        # Crop Right Half
        tmp2 = img.crop((pixel, 0, img.size[0], img.size[1]))
        tmp1 = ImageOps.mirror(tmp2)
        dst = Image.new('RGB', (tmp1.width + tmp2.width, tmp1.height))
        dst.paste(tmp1, (0, 0))
        dst.paste(tmp2, (tmp1.width, 0))
        # Save
        bin = io.BytesIO()
        dst.save(bin, 'JPEG')
        return bin