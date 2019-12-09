<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">

            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{name: 'welcome'}">{{ $t('home') }}</router-link>
                    </li>
                    <!-- Authentication Links -->

                    <li v-if="!$store.getters.getAccessToken" class="nav-item">
                        <router-link class="nav-link" :to="{name: 'login'}">{{ $t('login') }}</router-link>
                    </li>

                    <li v-if="$store.getters.getAccessToken" class="nav-item">
                        <router-link class="nav-link" :to="{name: 'users'}">{{ $t('users') }}</router-link>
                    </li>

                    <li v-if="$store.getters.getAccessToken" class="nav-item">
                        <router-link class="nav-link" :to="{name: 'departments'}">{{ $t('departments') }}</router-link>
                    </li>

                    <li v-if="$store.getters.getAccessToken" class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             {{ $store.state.currentUser.name }}<span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <div class="dropdown-item">
                                <router-link :to="{name:'user-edit', params: {id: $store.state.currentUser.id}}">{{ $t('profile') }}</router-link>
                            </div>
                            <div class="dropdown-item">
                                <a href="#" class="router-link" @click="$root.logout()">{{ $t('logout') }}</a>
                            </div>
                        </div>
                    </li>

                    <locale-changer class="ml-4"></locale-changer>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import LocaleChanger from './LocaleChanger';

export default {
    components: {
        LocaleChanger
    }
}
</script>