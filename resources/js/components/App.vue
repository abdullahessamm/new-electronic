<template>
    <div class="app">
        <div class="container">
            <h1 class="title"> {{ appName }} </h1>
            <h4> <span class="sub-title">Under development</span> </h4>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.app {
    background-color: #135ea2;
    color: #eee;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
    position: fixed;

    * { text-align: center }

    .sub-title {
    animation: color-animate linear;
    animation-duration: 2000ms;
    animation-iteration-count: infinite;
    animation-direction: alternate;
    animation-fill-mode: forwards;
}
}
</style>

<script>
export default {
    name: "app",
    data: () => ({
        appName: "New Electronic"
    }),
}
</script>