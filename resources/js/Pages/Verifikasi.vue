<script setup>
import {usePage} from '@inertiajs/vue3'

const page = usePage()
</script>

<template>
    <div>
        {{ page.props.sertifikat }}
    </div>
</template>