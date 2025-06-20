<template>
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay, when the modal is open -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div
                class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                        <h3 class="text-xl font-semibold text-charcoal-900 flex items-center">
                            <Eye class="h-5 w-5 mr-2 text-teal-600" />
                            Détails de la sanction
                        </h3>
                        <button @click="$emit('close')" class="text-gray-500 hover:text-gray-700">
                            <X class="h-6 w-6" aria-hidden="true" />
                        </button>
                    </div>

                    <div class="mt-3 text-center sm:mt-0 sm:text-left">
                        <div class="mt-2">
                            <!-- Sanction Details -->
                            <dl class="divide-y divide-gray-200">
                                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Type de sanction
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <span :class="sanctionTypeColor(sanction.regle.sanction_type)"
                                            class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium">
                                            {{ sanction.regle.sanction_type }}
                                        </span>
                                    </dd>
                                </div>
                                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Status
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <span :class="statusColor(sanction.status)"
                                            class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium">
                                            {{ statusLabel(sanction.status) ?? 'Pending' }}
                                        </span>
                                    </dd>
                                </div>
                                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Règle
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ sanction.regle.titre }}
                                    </dd>
                                </div>
                                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Description
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ sanction.regle.description }}
                                    </dd>
                                </div>

                                <!-- Apprenant Info -->
                                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Nom complet de l'apprenante
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ sanction.absences[0]?.apprenant.prenom }} {{
                                            sanction.absences[0]?.apprenant.nom }}
                                    </dd>
                                </div>
                                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Groupe
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ sanction.absences[0]?.apprenant.groupes[0].nom }}
                                    </dd>
                                </div>
                            </dl>

                            <!-- Timeline section -->
                            <div class="mt-6">
                                <h4 class="text-md font-semibold text-gray-700 mb-3">Timeline</h4>
                                <div class="space-y-3">
                                    <div v-if="sanction.absences[0]?.est_sanctionnée === 0" class="flex items-center">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 bg-light-blue-100 rounded-full flex items-center justify-center">
                                            <Calculator class="h-4 w-4 text-teal-600" />
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Calculée le</div>
                                            <div class="text-sm text-gray-500">{{ formatDate(sanction.created_at) }}
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="sanction.absences[0]?.est_sanctionnée === 1" class="flex items-center">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center">
                                            <CheckCircle class="h-4 w-4 text-teal-600" />
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Appliquée le</div>
                                            <div class="text-sm text-gray-500">{{ formatDate(sanction.created_at) }}
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="sanction.date_fin && sanction.status === 'active'"
                                        class="flex items-center">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 bg-golden-yellow-100 rounded-full flex items-center justify-center">
                                            <Calendar class="h-4 w-4 text-golden-yellow" />
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Expire le</div>
                                            <div class="text-sm text-gray-500">{{ formatDate(sanction.date_fin) }}</div>
                                        </div>
                                    </div>

                                    <div v-if="sanction.liftedOn" class="flex items-center">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 bg-light-blue-100 rounded-full flex items-center justify-center">
                                            <Shield class="h-4 w-4 text-light-blue-600" />
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Levée le</div>
                                            <div class="text-sm text-gray-500">{{ formatDate(sanction.liftedOn) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        @click="$emit('close')">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {
    Eye,
    Calculator,
    CheckCircle,
    Calendar,
    Shield,
    X
} from 'lucide-vue-next';

const props = defineProps({
    sanction: {
        type: Object,
        required: true
    },
    statusColor: {
        type: Function,
        required: true
    },
    statusLabel: {
        type: Function,
        required: true
    },
    formatDate: {
        type: Function,
        required: true
    },
        sanctionTypeColor: {
        type: Function,
        required: true
    }
});

const emit = defineEmits(['close']);

</script>

<style scoped>
/* Modal animation */
@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.relative {
    animation: modalSlideIn 0.3s ease-out;
}
</style>