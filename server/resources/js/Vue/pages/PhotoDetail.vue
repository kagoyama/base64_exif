<template>
    <!-- v-ifでundefined防止
    無いとsrcが'storage/app/undefined'になったり、
    日付が'Invalid Date'になったりする
    -->
    <div
        v-if="this.photo.upload_name !== ''"
    >
        <div id="routerLink">
            <RouterLink
                to="/photo/list"
                class="inline-block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
            >一覧に戻る</RouterLink>
        </div>
        <div class="flex flex-col lg:flex-row">
            <Image
                :photo="this.photo"
            />
        </div>
    </div>
</template>

<script>
import Image from '../components/Image.vue';
import globalFunction from '../../global/globalFunction';

export default {
    data() {
        return {
            userId: 1,
            photo: {
                upload_name: '',
            },
        }
    },
    methods: {
        async getPhotoData() {
            const url = '/api/photo/get/detail/' + this.photoId;
            await axios.get(url).then(response => {
                this.photo = response.data
                console.log(response.data)
            })
        },
        setDateLocale(date)
        {
            return globalFunction.setDateLocale(date);
        },
        getImageUrl(fileName){
            return globalFunction.getImageUrl(fileName);
        },
    },
    components: {
        Image: Image,
    },
    props: {
        photoId: Number,
    },
    mounted() {
        this.getPhotoData()
    }
}
</script>
