<template>
    <div>powtórki z kursu</div>
    <div>
        <p>{{ name }} - {{repAmount}}</p>
    </div>
</template>

<script>
export default {
    name: 'FastRepeating',
    props: [
        'courseId',
        'name',
        'repAmount'
    ],
    data() {
        return {

        };
    },
}
</script>

<style scoped>

</style>