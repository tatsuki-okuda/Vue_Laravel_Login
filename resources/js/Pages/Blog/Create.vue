<template>
  <app-layout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Blog
        </h2>
    </template>

    <div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
          <jet-form-section @submitted="createBlog">
              <template #title>Blog作成</template>
              <template #description>Blogの追加を行います</template>
              <template #form>
                  <div class="col-span-6 sm:col-span-4">
                    <jet-label for="title" value="タイトル" />
                    <jet-input
                        id="title"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.title"
                    />
                    
                  </div>
                  <div class="col-span-6 sm:col-span-4">
                    <jet-label for="content" value="コンテント" />
                    <textarea v-model="form.content" class="mt-1 block w-full form-input rounded-md shadow-sm"></textarea>
                    <jet-input-error :message="form.error('content')" class="mt-2" />
                  </div>
              </template>
              <template #actions>
              <jet-button class="bg-blue-700 text-base">
                作成
              </jet-button>
            </template>
          </jet-form-section>

      </div>
    </div>

  </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetFormSection from "@/Jetstream/FormSection";
    import JetInput from "@/Jetstream/Input";
    import JetLabel from "@/Jetstream/Label";
    import JetButton from "@/Jetstream/Button";
    import JetInputError from "@/Jetstream/InputError";


    export default {
        // props:['blogs'],
        props:{
            errors: {
                type: Object,
            }
        },
        components: {
            AppLayout,
            JetFormSection,
            JetInput,
            JetLabel,
            JetButton,
            JetInputError
        },
        data() {
          return {
            form: this.$inertia.form(
                {
                  _method: "POST",
                  title: "",
                  content: "",
                },
                {
                  bag: "blogCreate",
                  resetOnSuccess: false,
                }
            )
          };
        },
        methods:{
          createBlog(){
            this.form.post(route("blog.store"));
          }
        }
    }
</script>