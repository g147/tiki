<script>
export default {
    name: 'KanbanCard'
}
</script>
<script setup>
import { ref } from 'vue'

const isHovered = ref(false)

const handleMouseEnter = event => {
    isHovered.value = true
}
const handleMouseLeave = event => {
    isHovered.value = false
}
</script>

<template>
    <div class="kanban-card" @mouseenter="handleMouseEnter" @mouseleave="handleMouseLeave">
        <div class="kanban-card-body">
            <slot name="default"/>
            <Transition name="slide-fade">
                <div v-show="isHovered" class="kanban-card-menu">
                    <slot name="menu"/>
                </div>
            </Transition>
            <div class="kanban-card-title">
                <slot name="title"/>
            </div>
            <div class="kanban-card-text">
                <slot name="text" />
            </div>
        </div>
    </div>
</template>

<style lang="scss">
    .kanban-card {
        position: relative;
        margin-bottom: 10px;
        border: none;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0px 3px 20px -12px #b5b6ba;

        .kanban-card-menu {
            position: absolute;
            top: 0;
            right: 0;
            padding: 0.4rem;
        }

        .kanban-card-body {
            padding: 0.85rem;
        }

        .kanban-card-title {
            font-weight: 500;
            line-height: 1.4;
        }

        .kanban-card-text {
            color: #5c5c5c;
            line-height: 1.4;
            font-size: 0.95rem;
        }
    }
    .slide-fade-enter-active {
        transition: all 0.15s ease-out;
    }

    .slide-fade-leave-active {
        transition: all 0.2s cubic-bezier(1, 0.5, 0.8, 1);
    }

    .slide-fade-enter-from,
    .slide-fade-leave-to {
        transform: translateX(20px);
        opacity: 0;
    }
</style>
