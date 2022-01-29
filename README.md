# Symmetry Bot System

Fully automatic face recognition symmetry image generation / posting system for Hikakin and Seikin

#### **https://twitter.com/SYM_HIKA_SEI**

![Untitled](https://qiita-user-contents.imgix.net/https%3A%2F%2Fqiita-image-store.s3.ap-northeast-1.amazonaws.com%2F0%2F513165%2Feeb1ba6f-1439-2146-5e29-e71bc8045423.jpeg?ixlib=rb-4.0.0&auto=format&gif-q=60&q=75&w=1400&fit=max&s=a6206821c78f117ff1f0159f47f1d87d)

### Environment
```
Ubuntu 20.04 LTS / Windows 10
Python 3.9.10
PHP 7.4.1
```

## Change Log
January 30, 2022
- Change base processing lang to Python. Create class and rewrite everything.
- Search info was recieved via an API written in PHP.

September 6, 2021
- Added a function to post thumbnail images acquired from video database.

Angust 17th
- Python's face recognition library **face_recognition** is used for more accurate face detection.
- Image processing has also moved from OpenCV to **Pillow(Python Image Library)**.

First Commit
- Face Recognition: **OpenCV** of Face Recognition (Face API) is used.

## Notice
- The pip library "face_recognition" runs in C++, so **it may not work well on cloud platforms such as Heroku** (see the official repository for details).
- If you are a Windows user, please run `winget install cmake` and pass the PATH `C:\Program Files\CMake\bin`.