<script>
import ProductCard from '@/Components/Card/ProductCard.vue';
import { router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

export default {
    components: {
        ProductCard,
    },
    props: {
        response: {
            type: Object,
            required: false,
            default: () => ({}),
        },
    },
    data() {
        return {
            title: 'Hello World !',
        };
    },
    created() {
        // console.log(this.response);
    },
    methods: {
        getDataFromCard(obj, item) {
            router.visit(route('product.addCart'), {
                method: 'post', data: { id: item.id, qty: obj.qty }, preserveState: true, onSuccess: ({ props }) => {
                    if (props.flash.message.rt_code === 1) {
                        Swal.fire(`${item.name}成功加入購物車`);
                    }
                },
            });
        },
    },
};
</script>

<template>
  <section id="frontend-index" class="max-w-7xl mx-auto">
    <h1 class="title">{{ title }}</h1>

    <div class="flex gap-[30px] flex-wrap">
      <!-- <div v-for="item in response.rt_data ?? []" :key="item.id" class="card">
        <img :src="item.image" class="w-full aspect-[4/3] object-cover" alt="">
        <h3 class="name">商品名稱: {{ item.name }}</h3>
        <h3 class="name">商品價格: {{ item.price }}</h3>
        <h3 class="name">商品描述: {{ item.desc }}</h3>
      </div> -->
      <ProductCard v-for="item in response.rt_data ?? []" :key="item.id" :product-info="item"
        @add-cart="(obj) => getDataFromCard(obj, item)">
        測試123
        <template #text>
          測試456
        </template>
        789
      </ProductCard>
    </div>
  </section>
</template>

<style lang="scss" scoped>
#frontend-index {
    @apply w-full h-full overflow-y-auto;

    .title {
        @apply text-[6.25rem] text-center;
    }

    .card {
        @apply w-[calc(25%-22.5px)] border p-6;
    }
}</style>
