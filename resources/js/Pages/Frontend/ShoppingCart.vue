<script>

export default {
    props: {
        response: {
            type: Object,
            required: false,
            default: () => ({}),
        },
    },
    data() {
        return {

        };
    },
    created() {
        // console.log(this.response);
    },
    methods: {

    },
};
</script>

<template>
  <section id="frontend-cart" class="max-w-7xl mx-auto">
    <h1 class="title">購物車</h1>
    <table class="w-full">
      <thead>
        <tr>
          <th>#</th>
          <th class="w-[150px]">商品圖片</th>
          <th>商品名稱</th>
          <th>單價</th>
          <th>購買數量</th>
          <th>商品價格</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in response?.rt_data ?? []" :key="item.id">
          <td>{{ index + 1 }}</td>
          <td>
            <img :src="item.product.image" class="w-[150px] aspect-[4/3] object-cover" alt="">
          </td>
          <td>{{ item.product.name }}</td>
          <td>${{ item.product.price }}</td>
          <td>{{ item.qty }}</td>
          <td>${{ item.product.price * item.qty }}</td>
        </tr>
      </tbody>
    </table>
  </section>
</template>

<style lang="scss" scoped>
#frontend-cart {
    @apply w-full h-full overflow-y-auto;

    .title {
        @apply text-[6.25rem] text-center;
    }

    table {
        th, td {
            @apply text-center border border-black;
        }
    }

    // .card {
    //     @apply w-[calc(25%-22.5px)] border p-6;
    // }
}</style>
