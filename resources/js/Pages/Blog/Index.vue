<template>
  <app-layout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Blog
        </h2>
    </template>
    <div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div>
            <inertia-link :href="route('blog.create')" >
                <jet-button class="bg-blue-700 text-base mb-5">Blogを作成</jet-button>
            </inertia-link>
        </div>
        <table>
            <thead>
            <tr>
                <th>タイトル</th>
                <th>コンテンツ</th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="blog in blogs" :key="blog.id">
                    <td class="border px-4 py-2">{{ blog.title }}</td>
                    <td class="border px-4 py-2" v-html:="blog.content"></td>
                    <td class="border px-4 py-2 text-center">
                        <inertia-link :href="route('blog.edit', blog.id)">
                            <jet-button class="bg-green-500 text-base">更新</jet-button>
                        </inertia-link>
                    </td>
                    <td class="border px-4 py-2 text-center">
                        <jet-button @click="deleteBlog(blog.id)" class="bg-red-700 text-base">削除</jet-button>
                    </td>
                </tr>
            </tbody>
        </table>
      </div>
    </div>
  </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout';
    import JetButton from "@/Jetstream/Button";

    export default {
        props:['blogs'],
        components: {
            AppLayout,
            JetButton,
        },
        data() {
            return {
            form: this.$inertia.form(
                {
                    _method: "DELETE",
                }
            ),
            };
        },
        methods:{
            deleteBlog(id){
                this.form.post(route("blog.destroy", id), {
                    preserveScroll: true,
                });
            }
        }
    }
</script>