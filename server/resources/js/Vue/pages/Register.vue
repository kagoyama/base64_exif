<template>
    <Title title="写真登録" />
    <div class="mb-2">
        <input
            type="file"
            @change="this.displayUploadImg($event)"
            :value="this.file"
            class="block text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
            multiple
        >
    </div>
    <div class="space-y-8 lg:grid lg:grid-cols-4 gap-6 lg:space-y-0">
        <div
            v-for="(data, key) in this.images"
            :key="key"
        >
            <template v-if="data.includes('image/')">
                <img :src="data">
            </template>
            <template v-else-if="data.includes('video/')">
                <video controls :src="data"></video>
            </template>
            <!-- {{ data }} -->
        </div>
    </div>
    <button
        :disabled="this.uploadImages.length === 0"
        @click="registerImg"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
    >写真登録</button>
</template>

<script>
import Title from '../components/Title.vue';

export default {
    data () {
        return {
            user_id: 1,
            file: null,
            images: [],
            uploadImages: [],
            uploadImagesColumns: {
                comment: '',
                base64_encoded: '',
                user_id: '',
                publication_range: 0,
                publication_group: ''
            },
            isLoading: false
        }
    },
    methods: {
        // 写真を保存する
        async registerImg() {
            const url = '/api/photo/register';
            const params = this.uploadImages
            await axios.post(url, params).then(response => {
                const data = response.data
                alert(data)
                this.uploadImages = []
                this.images = []
                this.file = null
            })
        },
        // 写真を画面に表示
        async displayUploadImg(event) {
            // filesをarrayに変換
            const files = Array.from(event.target.files || event.dataTransfer.files);
            this.isLoading = true;
            // promiseを使って非同期処理を並行して実行
            const fileReadPromises = files.map((file, index) => {
                if (/*file.type === 'image/webp' ||*/ file.type === 'image/jpeg' || file.type === 'video/mp4') {
                    return this.formatBase64(file).then(base64File => {
                        // indexを含むことでファイルの順序を保存
                        return { index, base64File };
                    }).catch(error => {
                        alert('ファイルの読み込み中にエラーが発生しました: ' + error.message);
                        return null;
                    });
                } else {
                    alert('jpegまたはmp4のみ登録可能です');
                    return null;
                }
            });
            // Promise.allで全てのpromiseが解決するまで待つ
            const results = await Promise.all(fileReadPromises);
            results.forEach(result => {
                if (result) {
                    // base64Fileを指定して取り出す
                    const { base64File } = result;
                    this.images.push(base64File);
                    // deepcopyしないと全てのラジオボタンが同時に更新される
                    const uploadImage = globalFunction.deepCopy(this.uploadImagesColumns);
                    uploadImage.base64_encoded = base64File;
                    uploadImage.user_id = this.user_id;
                    this.uploadImages.push(uploadImage);
                }
            });
            this.isLoading = false;
            this.file = null;
        },
        formatBase64(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader()
                // onload~readAsDataUrlのワンセット
                reader.readAsDataURL(file)
                // onload中にセットする
                reader.onload = () => resolve(reader.result)
                reader.onerror = error => reject(error)
            })
        }
    },
    components: {
        Title: Title
    }
}
</script>
