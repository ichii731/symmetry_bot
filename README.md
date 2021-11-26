# Symmetry System

Fully automatic face recognition symmetry image generation / posting system for Hikakin and Seikin

**https://twitter.com/SYM_HIKA_SEI**

![Untitled](https://qiita-user-contents.imgix.net/https%3A%2F%2Fqiita-image-store.s3.ap-northeast-1.amazonaws.com%2F0%2F513165%2Feeb1ba6f-1439-2146-5e29-e71bc8045423.jpeg?ixlib=rb-4.0.0&auto=format&gif-q=60&q=75&w=1400&fit=max&s=a6206821c78f117ff1f0159f47f1d87d)

## Using

```
./launch.sh
```

### Environment

```
Ubuntu 20.04 LTS
PHP 7.4.1
Python 3.9
```

## Change Log

First Commit
- Face Recognition: **OpenCV** of Face Recognition (Face API) is used.

Angust 17th

- Python's face recognition library **face_recognition** is used for more accurate face detection.
- Image processing has also moved from OpenCV to **Pillow(Python Image Library)**.

※Operating on its own platform without using any external API

September 6th

- Added a function to post thumbnail images acquired from Hikakin's video database.  Specified by systemd to run at 18:00 every day.

## Tech Stack

[Backend]

Python / PHP

[Libraries]

Pip Installs Packages(Python)

- Pillow==8.3.1
- face_recognition ([GitHub Repo](https://github.com/ageitgey/face_recognition))

Composer (PHP)

- abraham/twitteroauth: ^2.0
- vlucas/phpdotenv: ^5.3

[Other]

- Systemd.Timer (Ubuntu 20.04 LTS)

## Notice

The pip library "face_recognition" runs in C++, so **it may not work well on cloud platforms such as Heroku** (see the official repository for details).

The Twitter API processing is done in PHP and the image processing is done in Python, which makes no sense to me...

So I've put it under MIT license, but it's better not to refer to this repo.
