<script setup lang="ts">
// Inertia
import { Head, useForm } from '@inertiajs/vue3';

// TS
import { type BreadcrumbItem } from '@/types';

// Vue/UI
import AppLayout from '@/layouts/AppLayout.vue';
import CardPequeno from '@/components/CardPequeno.vue';
import { Input, Select, DragAndDrop } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import { computed } from 'vue';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Upload',
        href: '/upload',
    },
];

interface FormData {
    categoria: string,
    categoria_nova: string,
    destinatario: string,
    destinatario_novo: string,
    documentos: FileList[]
}

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm<FormData>({
    categoria: '',
    categoria_nova: '',
    destinatario: '',
    destinatario_novo: '',
    documentos: [],
});

const submit = () => {
    form.post(route('store'), {
        preserveScroll: true,
        onSuccess: () => 1,
        onError: () => 1,
        onFinish: () => form.reset(),
    });
};

const criarNovaCategoria = computed(() => {
    return form.categoria_nova.length > 0;
});

const criarNovoDestinatario = computed(() => {
    return form.destinatario_novo.length > 0;
})

function limparCategoria(attr: string) {
    if (attr == 'categoria') {
        form.categoria = '';
    } else if (attr == 'destinatario') {
        form.destinatario = '';
    }
}

function setDocumentos(files: FileList[]) {
    form.documentos = files;
}
</script>

<template>
    <Head title="Upload" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <CardPequeno titulo="Categoria">
                    <Label for="categoria">Selecione uma das categorias</Label>
                    <Select id="categoria" 
                            v-model="form.categoria"
                            :disabled="criarNovaCategoria">
                        <option value='cultura'>Cultura</option>
                        <option value='infraestrutura'>Infraestrutura</option>
                        <option value='saude'>Saúde</option>
                    </Select>

                    <Separator class="my-4"/>

                    <Label for="categoria_nova">Ou crie uma nova</Label>
                    <Input id="categoria_nova"
                           type="text"
                           @change="limparCategoria('categoria')"
                           v-model="form.categoria_nova"
                           :tabindex="1"
                           placeholder="Digite aqui"/>
                </CardPequeno>

                <CardPequeno titulo="Destinatário">
                    <Label for="destinatario">Selecione um destinatário</Label>
                    <Select id="destinatario" 
                            v-model="form.destinatario"
                            :disabled="criarNovoDestinatario">
                        <option value='gov'>Governador</option>
                        <option value='vice-gov'>Vice Governador</option>
                        <option value='prefeito'>Prefeito</option>
                    </Select>

                    <Separator class="my-4"/>

                    <Label for="destinatario_novo">Ou crie uma nova</Label>
                    <Input id="destinatario_novo"
                           type="text"
                           @change="limparCategoria('destinatario')"
                           v-model="form.destinatario_novo"
                           :tabindex="1"
                           placeholder="Digite aqui"/>
                </CardPequeno>

                <CardPequeno titulo="Arquivo" class="md:row-span-2">
                    <DragAndDrop @files-selected="setDocumentos" :size_svg="100"/>
                </CardPequeno>
                
                <CardPequeno formato="linha" class="md:col-span-2" titulo="Arquivo" >
                    <div class="text-center">
                        <p>Amo muito minha esposa</p>
                    </div>
                </CardPequeno>

            </div>

        </div>
    </AppLayout>
</template>
