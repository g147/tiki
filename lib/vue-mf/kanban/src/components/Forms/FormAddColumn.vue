<script>
export default {
    name: 'FormAddColumn'
}
</script>
<script setup>
import { ref } from 'vue'
import { Button } from '@vue-mf/styleguide'
import KanbanCard from '../KanbanCard.vue'
import store from '../../store'

const props = defineProps({
    rowId: {
        type: Number
    }
})
const emit = defineEmits(['close'])

const title = ref('')

const handleAddColumn = () => {
    store.dispatch('addNewColumn', {
        title: title.value,
        rowId: props.rowId
    })
    emit('close')
}
</script>

<template>
    <KanbanCard>
        <textarea
            v-model="title"
            class="form-control"
            rows="3"
            placeholder="Add another list..."
        >{{ title }}</textarea>
    </KanbanCard>
    <Button sm @click="handleAddColumn">Add list</Button>
    <Button class="ml-2" variant="default" sm @click="$emit('close')">
        <i class="fas fa-times"></i>
    </Button>
</template>

<style lang="scss" scoped>
:deep(.card-body) {
    padding: 3px;
}
.btn-default {
    // background-color: rgba(228, 230, 240, 0.658);
    &:hover {
        background-color: rgba(9, 30, 66, 0.08);
    }
}
</style>
