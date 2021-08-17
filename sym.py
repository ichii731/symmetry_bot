# hikakin/seikin sym bot_system
# MIT Licenced by ©2021 ichiiP
# Unauthorized use is prohibited. Please contact the author when using it.
# Author:@ichii731 | https://ic731.net

# import libs
from PIL import Image, ImageOps
import os
import sys
import face_recognition

# Crop/Save Function
def sym_crop(pixel, in_file, out_file):
    # Crop Left Half
    img = Image.open(in_file)
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
    dst.save(out_file)

if __name__ == "__main__":
    args = sys.argv
    os.mkdir("out_img/" + args[1])
    # Face_Recognize!
    image = face_recognition.load_image_file("tmp_img/" + args[1] + "/default.jpg")
    face_locations = face_recognition.face_locations(image)
    if len(face_locations) == 0:
        exit
    else:
        for i in range(len(face_locations)):
            # Crop&Save
            top, right, bottom, left = face_locations[i]
            sym_pixel = ( right + left ) // 2
            sym_crop(sym_pixel, "tmp_img/" + args[1] + "/default.jpg", "out_img/" + args[1] + "/" + str(i) +"1.jpg")