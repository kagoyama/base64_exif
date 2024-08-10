<template>
    <header>
        <Nav />
    </header>
    <RouterView />
</template>

<script>
import Nav from '../Vue/layouts/Nav.vue'

export default {
    components: {
        Nav: Nav
    }
}
</script>
