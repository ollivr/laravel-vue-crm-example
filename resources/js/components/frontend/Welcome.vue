<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 p-5 bg-white border border-#cccccc rounded-lg">
                <h1 class="mt-4 text-center">{{ $t('info')}}</h1>
                <h3 class="mt-4 text-center">
                    {{ $t('please')}} <router-link :to="{name: 'login'}">{{ $t('logIn')}}</router-link>
                </h3>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Welcome',
    props: {

    },
    data() {
        return {

        }
    },
    mounted () {
    },
    methods: {

    },
}
</script>