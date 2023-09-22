<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Swal from 'sweetalert2';
import { Head, router } from '@inertiajs/vue3';

export default {
  components: {
    AuthenticatedLayout,
    Head,
  },
  props: {
    response: Object,
  },
  data() {
    return {
      listData: this.response?.rt_data ?? [],
    };
  },
  methods: {
    isPublic(num = 0) {
      if (![1, 2].includes(num)) return '';
      return num === 1 ? '公開' : '非公開';
    },
    deleteProducct(id) {
      Swal.fire({
        title: '確定要刪除嗎?',
        showDenyButton: true,
        confirmButtonText: '刪除',
        denyButtonText: '取消',
      }).then((result) => {
        if (result.isConfirmed) {
          // 刪除
          router.visit(route('product.delete'), { method: 'delete', data: { id: id } });
        }
      });
    },
  },
};

</script>

<template>
  <Head title="product" />
  <AuthenticatedLayout>
    {{ response.rt_data }}
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Product</h2>
        <Link :href="route('product.create')">
          <button type="button" class="font-semibold text-xl text-gray-800 leading-tight border border-black">
            新增商品
          </button>
        </Link>
      </div>
    </template>
    <section id="product" class="px-[15px] py-[10px] bg-white mt-[30px] rounded-[6px]">
      <table class="w-full">
        <thead>
          <tr>
            <th>#</th>
            <th>商品圖片</th>
            <th>商品名稱</th>
            <th>商品價格</th>
            <th>公開/非公開</th>
            <th>建立時間</th>
            <th>商品描述</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in listData" :key="item.id">
            <td>{{ index + 1 }}</td>
            <td>
              <img class="w-[150px] aspect-[4/3] object-cover mx-auto" :src="item.img_path" alt="商品圖片">
            </td>
            <td>{{ item.name }}</td>
            <td>${{ item.price }}</td>
            <td>{{ isPublic(item.public) }}</td>
            <td>{{ item.timeFormat }}</td>
            <td>{{ item.desc }}</td>
            <td>
              <div class="flex justify-center items-center gap-3">
                <Link :href="route('product.edit', { id: item.id })">
                  <button type="button" class="px-3 py-2 border border-black rounded-[5px]">編輯</button>
                </Link>
                <Link>
                  <button type="button" class="px-3 py-2 border border-black bg-[red] rounded-[5px] text-white"
                    @click="deleteProducct(item.id)">刪除</button>
                </Link>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </section>
  </AuthenticatedLayout>
</template>

    <style lang="scss" scoped>
    #product {
        table {
            th{
                @apply border border-black;
            }
            td {
                @apply text-center border border-black;
            }
        }
    }
</style>
