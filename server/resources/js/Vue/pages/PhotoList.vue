<template>
    <Title title="写真一覧" />
    <ul class="grid grid-cols-4 gap-2 lg:gap-6 space-y-0">
        <li
            v-for="(val, key) in this.photos"
            :key="key"
        >
            <RouterLink :to="{name:'PhotoDetail', params: {photoId:Number(val.id)}}">
                <Image :photo="val" />
            </RouterLink>
            <span>{{ val.id }}</span>
        </li>
    </ul>
</template>

<script>
import axios from 'axios';
import globalFunction from '../../global/globalFunction';
import Title from '../components/Title.vue';
import Image from '../components/Image.vue';

export default {
    data () {
        return {
            photos: []
        }
    },
    methods: {
        async getPhotoList() {
            const url = '/api/photo/get/all';
            await axios.get(url).then(response => {
                console.log(response.data)
                this.photos = response.data
            })
        },
        deepCopy(value) {
            return globalFunction.deepCopy(value);
        }
    },
    components: {
        Title: Title,
        Image: Image
    },
    mounted() {
        this.getPhotoList()
    }
}
</script>
