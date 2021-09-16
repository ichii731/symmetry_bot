# HIKAKIN&SEIKIN_SYMMETRY

Fully automatic face recognition symmetry image generation / posting system for Hikakin and Seikin

**https://twitter.com/SYM_HIKA_SEI**

![Untitled](https://qiita-user-contents.imgix.net/https%3A%2F%2Fqiita-image-store.s3.ap-northeast-1.amazonaws.com%2F0%2F513165%2Feeb1ba6f-1439-2146-5e29-e71bc8045423.jpeg?ixlib=rb-4.0.0&auto=format&gif-q=60&q=75&w=1400&fit=max&s=a6206821c78f117ff1f0159f47f1d87d)

## Using

```
./launch.sh
```

詳しい日本語での解説はQiitaを御覧ください。

https://qiita.com/ichii731/items/af03a038832f07039978

## Changes

8月17日まで

- 顔認識に**OpenCV**の顔認識(Face API)を利用。

8月17日から

- **より高精度な顔検出ができる**よう、Pythonの顔認識ライブラリ「face_recognition」を採用。
- 画像処理もOpenCV→**Pillow**(Python Image Library)に移行しました。

※現在のところGCP等の外部APIの導入予定はありません。

------

Until August 17th

- Use OpenCV's face recognition function for face recognition

Since August 17th

- It uses the Python face recognition library "face_recognition" for **more accurate face detection**.
- Image processing has also moved from OpenCV to **Pillow** (Python Image Library).

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

## Notice!

pipライブラリの「face_recognition」はC++で動作するのでHeroku等のクラウドプラットフォームではうまく機能しないかもしれません(そのへんは公式リポジトリを見てください〜)

本来公開するつもりじゃなかったのでTwitterAPI処理はPHP・画像処理はPythonとかいう意味のわからない仕様になっています…

なので一応MITライセンスにしときますがこんなrepoは参考にしないほうが良いですｗ

------

The pip library "face_recognition" runs in C++, so it may not work well on cloud platforms such as Heroku (see the official repository for details).

The Twitter API processing is done in PHP and the image processing is done in Python, which makes no sense to me...

So I've put it under MIT license, but it's better not to refer to this repo.
