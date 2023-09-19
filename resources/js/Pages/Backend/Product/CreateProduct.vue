<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Swal from 'sweetalert2';
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
export default {
    components: {
        AuthenticatedLayout,
        Head,
    },
    data() {
        return {
            formData: {
                name: '',
                price: '',
                public: '',
                desc: '',
            },
        };
    },
    methods: {
        submitData() {
            const { formData } = this;
            // 驗證
            router.visit(route('product.store'), {
                method: 'post',
                data: formData,
                preserveState: true,
                onSuccess: ({ props }) => {
                    // console.log(props);
                    if (props.flash.message.rt_code === 1) {
                        Swal.fire({
                            title: '新增成功',
                            showDenyButton: true,
                            confirmButtonText: '回列表',
                            denyButtonText: '取消',
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                router.get(route('product.list'));
                            }
                        });
                    }
                },
            });
        },
    },
};
</script>

<template>
  <Head title="Product" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Product 新增產品</h2>
      </div>
    </template>
    <section id="product-create" class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 bg-white mt-[30px] rounded-[6px]">
      <form @submit.prevent="submitData()">
        <label>商品名稱:
          <input v-model="formData.name" name="name" type="text" required>
        </label>
        <label>商品價格:
          <input v-model="formData.price" name="price" type="number" min="0" required>
        </label>
        <div class="flex items-center gap-[10px]">公開/非公開:
          <label>
            <input v-model="formData.public" name="public" type="radio" value="1" required>公開
          </label>
          <label>
            <input v-model="formData.public" name="public" type="radio" value="2">不公開
          </label>
        </div>
        <label>商品描述:
          <input v-model="formData.desc" name="desc" type="text">
        </label>
        <div class="flex justify-center items-center gap-[45px]">
          <button type="button" class="btn">取消新增</button>
          <button type="submit" class="btn">確認新增</button>
        </div>
      </form>
    </section>
  </AuthenticatedLayout>
</template>

<style lang="scss" scoped>
#product-create {
    form {
        @apply flex flex-col gap-[10px];
    }

    .btn {
        @apply border border-[#3b82f680] bg-[#3b82f680] font-bold px-[15px] py-[10px] rounded-[5px];
    }
}
</style>
