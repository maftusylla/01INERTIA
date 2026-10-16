<script setup>
import { useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    etudiants: {
        type: Object,
        required: true,
    },
    groupes: {
        type: Object,
        required: true,
    },
});

const formEtudiant = useForm({
    nom_complet: '',
    sexe: '',
    niveau: '',
});

function ajouterEtudiant() {
    formEtudiant.post('/etudiants', {
        onSuccess: () => formEtudiant.reset(),
    });
}

const formGroupe = useForm({
    taille_groupe: 4,
});

function genererGroupes() {
    formGroupe.post('/groupes/generer');
}

function libellePagination(label) {
    if (label.includes('Previous')) return '← Précédent';
    if (label.includes('Next')) return 'Suivant →';
    return label;
}
</script>

<template>
    <main class="min-h-screen bg-gray-50 px-4 py-8 text-gray-900 sm:px-8">
        <div class="mx-auto max-w-7xl space-y-8">

            <header>
                <h1 class="text-3xl font-bold tracking-tight">
                    Gestion des étudiants
                </h1>
                <p class="mt-2 text-gray-600">
                    Ajoutez les étudiants et répartissez-les dans des groupes équilibrés.
                </p>
            </header>

            <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="mb-6 text-xl font-semibold">
                    Ajouter un étudiant
                </h2>

                <form
                    @submit.prevent="ajouterEtudiant"
                    class="grid grid-cols-1 gap-5 md:grid-cols-2"
                >
                    <div>
                        <label for="nom_complet" class="mb-2 block text-sm font-medium">
                            Nom complet
                        </label>

                        <input
                            id="nom_complet"
                            v-model="formEtudiant.nom_complet"
                            type="text"
                            name="nom_complet"
                            placeholder="Ex. : Aminata Ndiaye"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                        />

                        <p
                            v-if="formEtudiant.errors.nom_complet"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ formEtudiant.errors.nom_complet }}
                        </p>
                    </div>

                    <div>
                        <label for="sexe" class="mb-2 block text-sm font-medium">
                            Sexe
                        </label>

                        <select
                            id="sexe"
                            v-model="formEtudiant.sexe"
                            name="sexe"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                        >
                            <option value="" disabled>
                                Choisir le sexe
                            </option>
                            <option value="Masculin">Masculin</option>
                            <option value="Feminin">Féminin</option>
                        </select>

                        <p
                            v-if="formEtudiant.errors.sexe"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ formEtudiant.errors.sexe }}
                        </p>
                    </div>

                    <div>
                        <label for="niveau" class="mb-2 block text-sm font-medium">
                            Niveau d'études
                        </label>

                        <select
                            id="niveau"
                            v-model="formEtudiant.niveau"
                            name="niveau"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                        >
                            <option value="" disabled>
                                Choisir le niveau
                            </option>
                            <option value="niveau 1">Niveau 1</option>
                            <option value="niveau 2">Niveau 2</option>
                            <option value="niveau 3">Niveau 3</option>
                        </select>

                        <p
                            v-if="formEtudiant.errors.niveau"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ formEtudiant.errors.niveau }}
                        </p>
                    </div>

                    <div class="flex items-end">
                        <button
                            type="submit"
                            :disabled="formEtudiant.processing"
                            class="w-full rounded-lg bg-indigo-600 px-5 py-3 font-medium text-white transition hover:bg-indigo-700 disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            {{
                                formEtudiant.processing
                                    ? 'Enregistrement...'
                                    : 'Ajouter l’étudiant'
                            }}
                        </button>
                    </div>
                </form>
            </section>

            <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
                    <h2 class="text-xl font-semibold">
                        Liste Etudiants
                    </h2>

                    <span class="rounded-full bg-indigo-50 px-3 py-1 text-sm font-medium text-indigo-700">
                        {{ props.etudiants.length }} étudiant(s)
                    </span>
                </div>

                <div
                    v-if="props.etudiants.length === 0"
                    class="rounded-lg bg-gray-50 px-4 py-8 text-center text-gray-500"
                >
                    Aucun étudiant en attente d'affectation.
                </div>

                <div v-else class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="border-b border-gray-200 bg-gray-50 text-gray-600">
                            <tr>
                                <th class="px-4 py-3 font-medium">Nom complet</th>
                                <th class="px-4 py-3 font-medium">Sexe</th>
                                <th class="px-4 py-3 font-medium">Niveau</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                                <tr
                                    v-for="etudiant in props.etudiants.data"
                                    :key="etudiant.id"
                                    class="hover:bg-gray-50"
                                >
                                <td class="px-4 py-3 font-medium">
                                    {{ etudiant.nom_complet }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ etudiant.sexe }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ etudiant.niveau }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                <div
                    v-if="props.etudiants.last_page > 1"
                    class="mt-5 flex flex-wrap items-center justify-between gap-3"
                >
                    <p class="text-sm text-gray-600">
                        Page {{ props.etudiants.current_page }}
                        sur {{ props.etudiants.last_page }}
                        — {{ props.etudiants.total }} étudiant(s)
                    </p>

                    <nav class="flex flex-wrap gap-2" aria-label="Pagination des étudiants">
                        <template
                            v-for="lien in props.etudiants.links"
                            :key="lien.label"
                        >
                            <Link
                                v-if="lien.url"
                                :href="lien.url"
                                preserve-scroll
                                :aria-current="lien.active ? 'page' : undefined"
                                :class="[
                                    'rounded-lg border px-3 py-2 text-sm',
                                    lien.active
                                        ? 'border-indigo-600 bg-indigo-600 text-white'
                                        : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50'
                                ]"
                            >
                                {{ libellePagination(lien.label) }}
                            </Link>

                            <span
                                v-else
                                class="rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-400"
                            >
                                {{ libellePagination(lien.label) }}
                            </span>
                        </template>
                    </nav>
                </div>

                </div>
            </section>

            <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="mb-2 text-xl font-semibold">
                    Générer les groupes
                </h2>

                <p class="mb-6 text-sm text-gray-600">
                    Choisissez le nombre d'étudiants souhaité par groupe.
                </p>

                <form
                    @submit.prevent="genererGroupes"
                    class="flex flex-col items-start gap-4 sm:flex-row sm:items-end"
                >
                    <div class="w-full sm:max-w-xs">
                        <label
                            for="taille_groupe"
                            class="mb-2 block text-sm font-medium"
                        >
                            Nombre d'étudiants par groupe
                        </label>

                        <input
                            id="taille_groupe"
                            v-model.number="formGroupe.taille_groupe"
                            type="number"
                            name="taille_groupe"
                            min="2"
                            max="100"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                        />

                        <p
                            v-if="formGroupe.errors.taille_groupe"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ formGroupe.errors.taille_groupe }}
                        </p>
                    </div>

                    <button
                        type="submit"
                        :disabled="
                            formGroupe.processing ||
                            props.etudiants.length === 0
                        "
                        class="rounded-lg bg-emerald-600 px-5 py-3 font-medium text-white transition hover:bg-emerald-700 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        {{
                            formGroupe.processing
                                ? 'Génération...'
                                : 'Générer les groupes'
                        }}
                    </button>
                </form>
            </section>

            <section class="space-y-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <h2 class="text-2xl font-bold">
                        Groupes constitués
                    </h2>

                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-sm font-medium text-emerald-700">
                        {{ props.groupes.length }} groupe(s)
                    </span>
                </div>

                <div
                    v-if="props.groupes.length === 0"
                    class="rounded-2xl border border-gray-200 bg-white px-4 py-8 text-center text-gray-500"
                >
                    Aucun groupe n'a encore été constitué.
                </div>

                <div
                    v-else
                    class="grid grid-cols-1 gap-5 lg:grid-cols-2"
                >
                    <article
                        v-for="groupe in props.groupes.data"
                        :key="groupe.id"
                        class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm"
                    >
                        <div class="flex items-center justify-between gap-3 border-b border-gray-200 bg-gray-50 px-5 py-4">
                            <h3 class="font-semibold">
                                {{ groupe.nom }}
                            </h3>

                            <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">
                                {{ groupe.etudiants.length }} étudiant(s)
                            </span>
                        </div>

                        <div
                            v-if="groupe.etudiants.length === 0"
                            class="p-5 text-sm text-gray-500"
                        >
                            Aucun étudiant dans ce groupe.
                        </div>

                        <div v-else class="divide-y divide-gray-100">
                            <div
                                v-for="etudiant in groupe.etudiants"
                                :key="etudiant.id"
                                class="flex flex-wrap items-center justify-between gap-2 px-5 py-4"
                            >
                                <div>
                                    <p class="font-medium">
                                        {{ etudiant.nom_complet }}
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ etudiant.sexe }}
                                    </p>
                                </div>

                                <span class="rounded-md bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">
                                    {{ etudiant.niveau }}
                                </span>
                            </div>
                        </div>
                    </article>
                </div>

                <div
                    v-if="props.groupes.last_page > 1"
                    class="flex flex-wrap items-center justify-between gap-3"
                >
                    <p class="text-sm text-gray-600">
                        Page {{ props.groupes.current_page }}
                        sur {{ props.groupes.last_page }}
                        — {{ props.groupes.total }} groupe(s)
                    </p>

                    <nav class="flex flex-wrap gap-2" aria-label="Pagination des groupes">
                        <template
                            v-for="lien in props.groupes.links"
                            :key="lien.label"
                        >
                            <Link
                                v-if="lien.url"
                                :href="lien.url"
                                preserve-scroll
                                :aria-current="lien.active ? 'page' : undefined"
                                :class="[
                                    'rounded-lg border px-3 py-2 text-sm',
                                    lien.active
                                        ? 'border-emerald-600 bg-emerald-600 text-white'
                                        : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50'
                                ]"
                            >
                                {{ libellePagination(lien.label) }}
                            </Link>

                            <span
                                v-else
                                class="rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-400"
                            >
                                {{ libellePagination(lien.label) }}
                            </span>
                        </template>
                    </nav>
                </div>

            </section>

        </div>
    </main>
</template>

