<script setup>
import {CardHorizontal} from '@/Components/General/tes'
const props = defineProps({
    type: String,
})
</script>

<template>
    <div class="w-full">
        <CardHorizontal v-if="props.type == 'card-horizontal'" />
    </div>
</template>