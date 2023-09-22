<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Swal from 'sweetalert2';
import { Head, router } from '@inertiajs/vue3';

export default {
  components: {
    AuthenticatedLayout,
    Head,
  },
  data() {
    return {
      formData: {
        name: this.response?.rt_data?.name ?? '',
        price: this.response?.rt_data?.price ?? '',
        public: this.response?.rt_data?.publuc ?? '',
        desc: this.response?.rt_data?.desc ?? '',
      },
    };
  },
  methods: {
    SubmitData() {
      const { formData, response } = this;
      //  驗證
      Swal.fire({
        title: `確認更新商品: ${response?.rt_data?.name ?? ''}?`,
        showDenyButton: true,
        confirmButtonText: '更新',
        denyButtonText: '取消',
      }).then((result) => {

        if (result.isConfirmed) {
          router.visit(router('product.update'), { method: 'put', data: { formData, id: response.rt_data },
            preserveState: true,
            onSuccess: ({ props }) => {
              if (props.flash.message.rt_code === 1) {
                Swal.fire({
                  title: '更新成功',
                  showDenyButton: true,
                  confirmButtonText: '回列表',
                  denyButtonText: '取消',
                }).then((result) => {
                  if (result.isConfirmed) {
                    router.get(router('product.list'));
                  }
                });
              }
            },
          });
        }
      });
    },
    inputClass(item) {
      if (!item) return '';
      return 'border-[red] rounded-[5px]';
    },
  },
};
</script>

<template>
  <Head title="product-create" />
  <AuthenticatedLayout>

    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Product 編輯商品</h2>
      </div>
    </template>
    <section id="product-create" class="px-[15px] py-[10px]">
      <form @submit.prevent="SubmitData()">
        <label>
          商品名稱
          <input v-model="formData.name" :class="{ 'border-[red]': $page.props?.errors['formData.name'] }" name="name" type="text" required>
          <div>{{ $page.props?.errors['formData.name'] ?? '' }}</div>
        </label>
        <label>
          商品價格
          <input v-model="formData.price" :class="inputClass($page.props?.errors['formData.name'])" name="price" type="number" required>
          <div>{{ $page.props?.errors['formData.price'] ?? '' }}</div>
        </label>
        <div class="flex items-center gap-[10px]">
          公開/非公開:
          <label>
            <input v-model="formData.publice" type="radio" value="1" required>
            公開
          </label>
          <label>
            <input v-model="formData.publice" type="radio" value="2">
            非公開
          </label>
        </div>
        <label>
          商品描述
          <input v-model="formData.desc" type="text" name="desc">
        </label>>
        <div class="flex justify-center items-center gap-[45px]">
          <Link :href="route('product.list')">
            <button class="btn" type="button">取消編輯</button>
          </Link>
          <button class="btn" type="submit">更新</button>
        </div>
      </form>
    </section>
  </AuthenticatedLayout>
</template>

<style lang="scss" scoped>
#product-create {
    form {
        @apply flex flex-col gap-[10px];

        .btn {
            @apply border border-[#3b82f680] bg-[#3b82f680] font-bold px-[15px] py-[10px] rounded-[5px];
        }
    }
}
</style>
