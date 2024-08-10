import globalConst from './globalConst'

const globalFunction = {
    getImageUrl(fileName){
        return new URL(globalConst.imgPath + `${fileName}`, import.meta.url).href
    },
    setDateLocale(date)
    {
        return new Date(date).toLocaleString('ja-JP')
    },
    deepCopy(value) {
        return JSON.parse(JSON.stringify(value));
    },
    // routeMatch(str)
    // {
    //     // js上でthis.$routeが使えない
    //     // this.$route.path.match(/list$/)
    //     return this.$route.name === str;
    // }
}

export default globalFunction
