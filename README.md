# 環境構築

## 手順
1. `.env`を作成しポートなどを任意に設定する
```
$ cp .env/example .env
```

2. `docker-compose`をかける
```
$ docker-compose up -d --build
```

3. `web`コンテナ内に入り各種コマンドを実行
```
$ docker exec -it exif_web bash

// コンテナ内
# composer install
# php artisan migrate
```
4. `node_modules`作成  
※以降はホストPCで行ってください
```
$ cd server
$ npm install
または
$ yarn install
```

4. `vite`を起動する
```
$ npm run dev
または
$ yarn dev
```

## 各ページ
- /exif/{photoId}  
登録した写真のbase64_encodeやexifデータを表示

- /{any?}  
SPAページ。写真登録・写真一覧の表示