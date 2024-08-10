import Register from '../Vue/pages/Register.vue'
import PhotoList from '../Vue/pages/PhotoList.vue'
import PhotoDetail from '../Vue/pages/PhotoDetail.vue'

const routes = [
    { path: '/', name: 'Register', component: Register },
    { path: '/photo/list', name: 'PhotoList', component: PhotoList },
    // props:photoIdに写真idを渡す
    // そのままだとstring型で渡るのでNumberにキャストする
    { path: '/photo/detail/:photoId', name: 'PhotoDetail', component: PhotoDetail, props: (route) => ({photoId: Number(route.params.photoId)})},
]

export default routes
