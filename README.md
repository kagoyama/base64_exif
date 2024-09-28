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
```
4. `server/.env`をつくる
```
# cp .env.example .env
# php artisan key:generate
```
`server/.env`のDB項目が以下であること確認
```
# docker db
DB_CONNECTION=mysql
DB_HOST=exif_db
DB_PORT=3306
DB_DATABASE=exif_db
DB_USERNAME=user
DB_PASSWORD=user
```
`migrate`実行
```
# php artisan migrate
```
5. `node_modules`作成  
※以降はホストPCで行ってください
```
$ cd server
$ npm install
または
$ yarn install
```

6. `vite`を起動する
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