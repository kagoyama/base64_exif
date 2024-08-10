<template>
    <div :class="{'lg:w-1/2 w-full': this.isNotListPage}">
        <div
            class="relative overflow-hidden"
            ref="heightControl"
            :style="{height:higherHeightPx}"
        >
            <img
                ref="targetImg"
                :src="getImageUrl(this.photo.upload_name)"
                :class="{'absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2': this.isNotListPage, 'w-full': this.isNotListPage === false}"
                @load="setMinHeight"
            />
        </div>
        <template v-if="this.isNotListPage">
            <div>撮影日：{{ this.photo.shot_date }}</div>
            <div>投稿者：{{ this.photo.user_name }}さん</div>
        </template>

        <div
            class="lg:w-1/2 w-full"
            style="position: absolute;overflow: hidden;"
        >
            <iframe
                v-if="this.photo.gps_url !== '' && this.$route.name === 'PhotoDetail'"
                :src="this.photo.gps_url"
                width="100%"
                height="auto"
                style="border:0;"
            />
        </div>
    </div>
</template>

<script>
import globalFunction from '../../global/globalFunction';
export default {
    data() {
        return {
            isNotListPage: false,
            imgHeight: 0,
        }
    },
    methods: {
        setMinHeight() {
            // ref属性を指定してheightを取得
            // 画像が対象のためかmountedでとれないので画像が@loadされたら取得
            this.imgHeight = this.$refs.targetImg.offsetHeight;
        },
        setIsNotListPage() {
            this.isNotListPage = (this.$route.path.match(/list$/)) ? false : true;
        },
        setDateLocale(date) {
            return globalFunction.setDateLocale(date);
        },
        getImageUrl(fileName){
            return globalFunction.getImageUrl(fileName);
        }
    },
    computed: {
        higherHeightPx() {
            if (this.isNotListPage)
            {
                // computedでimgHeightが@loadで取得されてからセットする
                return this.imgHeight !== 0 ? this.imgHeight + 'px' : '';
            }
        }
    },
    props: {
        image: String,
        photo: Object
    },
    mounted() {
        this.setIsNotListPage();
    }
}
</script>
