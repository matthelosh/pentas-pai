<script setup>

</script>
<template>
    <div class="w-screen h-screen flex items-center justify-center overflow-x-hidden">
        <div class="text-4xl text-gray-900 drop-shadow text-center">
            <h1>Error:</h1>
            {{ $page.props.errors }}
        </div>
    </div>
</template>