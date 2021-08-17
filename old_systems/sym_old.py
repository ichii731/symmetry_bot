import cv2
import sys
import os
import math
import numpy as np

def symmtry_face_default(in_image_path, out_image_path):
    image = cv2.imread(in_image_path)
    height, width, color = image.shape
    cascade = cv2.CascadeClassifier("corpus/haarcascade_frontalface_default.xml")
    facerect = cascade.detectMultiScale(image, scaleFactor=1.2, minNeighbors=2, minSize=(10, 10))

    if len(facerect) == 0:
        return False

    rect = facerect[0]
    start_x = rect[0]
    face_width = rect[2]
    center_x = int(math.floor(start_x + face_width/2.0))

    left_image = image[0:height, 0:center_x]
    right_image = left_image[:,::-1]
    out_image = cv2.hconcat([left_image, right_image])

    cv2.imwrite(out_image_path, out_image)
    return True

def symmtry_face_tree(in_image_path, out_image_path):
    image = cv2.imread(in_image_path)
    height, width, color = image.shape
    cascade = cv2.CascadeClassifier("corpus/haarcascade_frontalface_alt_tree.xml")
    facerect = cascade.detectMultiScale(image, scaleFactor=1.2, minNeighbors=2, minSize=(10, 10))

    if len(facerect) == 0:
        return False

    rect = facerect[0]
    start_x = rect[0]
    face_width = rect[2]
    center_x = int(math.floor(start_x + face_width/2.0))

    left_image = image[0:height, 0:center_x]
    right_image = left_image[:,::-1]
    out_image = cv2.hconcat([left_image, right_image])

    cv2.imwrite(out_image_path, out_image)
    return True

def symmtry_face_default_alt2(in_image_path, out_image_path):
    image = cv2.imread(in_image_path)
    height, width, color = image.shape
    cascade = cv2.CascadeClassifier("corpus/haarcascade_frontalface_alt2.xml")
    facerect = cascade.detectMultiScale(image, scaleFactor=1.2, minNeighbors=2, minSize=(10, 10))

    if len(facerect) == 0:
        return False

    rect = facerect[0]
    start_x = rect[0]
    face_width = rect[2]
    center_x = int(math.floor(start_x + face_width/2.0))

    left_image = image[0:height, 0:center_x]
    right_image = left_image[:,::-1]
    out_image = cv2.hconcat([left_image, right_image])

    cv2.imwrite(out_image_path, out_image)
    return True

if __name__ == "__main__":
    args = sys.argv
    os.mkdir("out_img/" + args[1])
    symmtry_face_default("tmp_img/" + args[1] + "/default.jpg", "out_img/" + args[1] + "/1.jpg")
    symmtry_face_tree("tmp_img/" + args[1] + "/default.jpg", "out_img/" + args[1] + "/2.jpg")
    symmtry_face_default_alt2("tmp_img/" + args[1] + "/default.jpg", "out_img/" + args[1] + "/3.jpg")
