<template>
    <div>

        <nav class="navbar navbar-expand-md navbar-dark navbar-custom fixed-top">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
                    aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-awesome fas fa-bars"></span>
                <span class="navbar-toggler-awesome fas fa-times"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <router-link class="nav-link page-scroll" to="/">HOME <span class="sr-only">(current)</span>
                        </router-link>
                    </li>
                </ul>
                <span class="nav-item social-icons">
                <span class="fa-stack">
                    <a target="_blank" href="https://www.facebook.com/rbc.ru/">
                        <span class="hexagon"></span>
                        <i class="fab fa-facebook-f fa-stack-1x"></i>
                    </a>
                </span>
                <span class="fa-stack">
                    <a target="_blank" href="https://twitter.com/ru_rbc">
                        <span class="hexagon"></span>
                        <i class="fab fa-twitter fa-stack-1x"></i>
                    </a>
                </span>
            </span>
            </div>
        </nav>

    </div>
</template>

<script>
    export default {
        name: "Header"
    }
</script>

<style scoped>
    .nav-item a{
        color: #14bf98!important;
    }
</style>