# 画像関連処理について

## base64_encode/decode

### base64_encode
1. 画像データ（バイナリデータ）をbase64_encodeで`データURIスキーム`に変換する
- `データURIスキーム`とは外部データを参照せず、直接html内で使用できる仕組み
```
// data:がファイル形式を指す
// base64,以降が画像データのencode
data:image/jpeg;base64,/9j/4SBrRXhpZgAATU0AKgAAAAgADAEAAAMAAAABD6AAAAEBA...
```

2. `base64_encode`を使用すれば画像の実体が不要
- `データURIスキーム`をそのままsrcに充てると画像が表示できる

```
<img src="data:image/jpeg;base64,/9j/4SBrRXhpZgAATU0AKgAAAAgADAEAAAMAAAABD6AAAAEBA...."/>
```
- ただしこの場合、キャッシュはされなくなる（されにくくなる？）
- 元のデータより30%ほどサイズが増える
### base64_decode
1. encodeされたデータを元の画像データ（バイナリデータ）に戻す

## exif_read_data
撮影された写真の撮影日や座標等のデータを読み出す