<script setup>

</script>

<template>
    <div class="overlay fixed top-0 right-0 bottom-0 left-0 z-50 bg-black bg-opacity-50 flex items-center justify-center" @click="$emit('close')">
        <div class="dialog w-2/4 h-2/3  rounded shadow">
            <slot />
        </div>
    </div>
</template>