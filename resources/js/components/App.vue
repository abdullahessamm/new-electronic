<template>
    <div class="app">
        <h1 class="title"> {{ appName }} </h1>
        <h4> <span class="sub-title">Under development</span> </h4>
    </div>
</template>

<script>
export default {
    name: "app",
    data: () => ({
        appName: "New Electronic"
    }),
}
</script>