<template>
    <div>
        <ckeditor
            :editor="editor"
            v-model="inputValue"
            :config="editorConfig"
        ></ckeditor>
    </div>
</template>

<script>
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

    export default {
        name: 'ckeditor-component',
        props: {
          value: {
            type: String,
            required: true
          }
        },
        computed: {
          inputValue: {
            get() {
              return this.value; 
            },
            set(value) {
              this.$emit('input', value); 
            }
          }
        },
        data() {
            return {
                editor: ClassicEditor,
                // editorData: '<p>Content of the editor.</p>',
                editorConfig: {
                    language: 'ja'
                }
            };
        }
    }
</script>