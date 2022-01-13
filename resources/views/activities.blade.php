@extends('layouts.app')

@section('content')
    <activities
        :user="user"
        :account="{{ json_encode($account) }}"
        :developers="{{ json_encode($account->developers) }}"
        inline-template
    >
        <div class="tw-container tw-mx-auto tw-px-2">
            <div class="tw-flex tw-flex-wrap tw--mx-2">
                <div class="tw-w-full md:tw-w-2/4 lg:tw-w-1/3 xl:tw-w-1/4 tw-px-2">
                    <div class="tw-p-4 tw-rounded-lg tw-bg-white tw-shadow">
                        <label class="tw-block">
                            <span class="tw-text-gray-700">Choose A Developer</span>
                            <select
                                v-model="selectedDeveloper"
                                class="tw-form-select tw-block tw-w-full tw-mt-1"
                            >
                                <option
                                    :value="developer.id"
                                    v-for="(developer, index) in developers"
                                >
                                    @{{ developer.name }}
                                </option>
                            </select>
                        </label>

                        <label class="tw-block tw-mt-6">
                            <span class="tw-text-gray-700">Choose a Date Range</span>
                            <input
                                v-model="activitiesDuration"
                                type="text"
                                class="tw-form-input tw-mb-4 tw-block tw-w-full"
                                id="datepicker"
                                placeholder="Developer Activity"
                            >

                            <span class="datepicker-section tw-block tw-text-center"></span>
                        </label>

                        <button
                            :disabled="!startDate || !endDate"
                            class="tw-block tw-w-full tw-mt-6 tw-btn tw-btn-primary"
                            @click="getData"
                        >
                            Get Activities
                        </button>
                    </div>
                </div>

                <div class="tw-w-full md:tw-w-2/4 lg:tw-w-2/3 xl:tw-w-3/4 tw-px-2">
                    <div class="tw-flex tw-flex-wrap tw--mx-2">
                        <div class="tw-w-full xl:tw-w-1/3 tw-px-2 tw-mt-12 md:tw-mt-0" v-show="todos.data.length">
                            <div class="tw-bg-white tw-rounded-lg tw-shadow-sm hover:tw-shadow-lg tw-transition-shadow tw-transition-150 tw-transition-ease-in-out">
                                <div class="tw-text-2xl lg:tw-text-xl tw-py-3 tw-bg-indigo-200 tw-rounded-t-lg tw-text-center tw-text-gray-900">
                                    Todos participated In
                                </div>

                                <div class="tw-flex tw-flex-wrap tw-p-4 tw--mx-2">
                                    <div class="tw-w-full tw-text-center tw-px-2">
                                        <div
                                            class="tw-flex tw-flex-col tw-leading-relaxed"
                                            v-for="(todo, todoIndex) in todos.data"
                                        >
                                            <a
                                                class="tw-py-2 tw-px-4 tw-text-lg md:tw-text-base tw-text-blue-600 tw-text-left tw-rounded-lg hover:tw-bg-indigo-100"
                                                :href="`/accounts/${account.id}/projects/${todo.project.id}/todos/${todo.id}`"
                                            >
                                                <i
                                                    :class="{'fa-check-square-o' : todo.completed, 'fa-square-o': !todo.completed }"
                                                    class="fa fa-lg tw-text-green-400 tw-mr-3"
                                                ></i>
                                                @{{ todo.title }}
                                            </a>

                                            <div class="tw-my-2 tw-mx-8 tw-border-t-1" v-if="todoIndex+1 < todos.data.length"></div>
                                        </div>

                                        <button
                                            :class="{'tw-hidden': todos.isItLatestPage }"
                                            class="tw-w-full tw-mt-6 tw-btn tw-btn-default tw-rounded"
                                            @click="fetchTodos"
                                        >
                                            Load More Todos...
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tw-w-full xl:tw-w-1/3 tw-px-2 tw-mt-4 xl:tw-mt-0" v-show="projects.data.length">
                            <div class="tw-bg-white tw-rounded-lg tw-shadow-sm hover:tw-shadow-lg tw-transition-shadow tw-transition-150 tw-transition-ease-in-out">
                                <div class="tw-text-2xl lg:tw-text-xl tw-py-3 tw-bg-indigo-200 tw-rounded-t-lg tw-text-center tw-text-gray-900">
                                    Projects participated In
                                </div>

                                <div class="tw-flex tw-flex-wrap tw-p-4 tw--mx-2">
                                    <div class="tw-w-full tw-px-2">
                                        <div
                                            class="tw-flex tw-flex-col tw-leading-relaxed"
                                            v-for="(project, projectIndex) in projects.data"
                                        >
                                            <a
                                                class="tw-py-2 tw-px-4 tw-text-lg md:tw-text-base tw-text-blue-600 tw-rounded-lg hover:tw-bg-indigo-100"
                                                :href="`/accounts/${account.id}/projects/${project.id}`"
                                            >
                                                @{{ project.name }}
                                            </a>

                                            <div class="tw-my-2 tw-mx-8 tw-border-t-1" v-if="projectIndex+1 < projects.data.length"></div>
                                        </div>

                                        <button
                                            :class="{'tw-hidden': projects.isItLatestPage }"
                                            class="tw-w-full tw-mt-6 tw-btn tw-btn-default tw-rounded"
                                            @click="fetchProjects"
                                        >
                                            Load More Projects...
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tw-w-full xl:tw-w-1/3 tw-px-2 tw-mt-4 xl:tw-mt-0" v-if="activities">
                            <div class="tw-bg-white tw-rounded-lg tw-shadow-sm hover:tw-shadow-lg tw-transition-shadow tw-transition-150 tw-transition-ease-in-out">
                                <div class="tw-text-2xl lg:tw-text-xl tw-py-3 tw-bg-indigo-200 tw-rounded-t-lg tw-text-center tw-text-gray-900">
                                    Activities Summary
                                </div>

                                <div class="tw-flex tw-flex-wrap tw-p-4 tw--mx-2">
                                    <div class="tw-w-full tw-px-2">
                                        <div class="tw-flex tw-flex-col tw-leading-relaxed">
                                            <ul class="tw-list-none tw-leading-loose tw-text-gray-700">
                                                <li>
                                                    <i class="fa fa-check fa-lg tw-text-green-400"></i>
                                                    <span class="tw-font-bold">@{{ activities.hoursSpent }}</span> @{{ pluralize('hour', activities.hoursSpent) }} spent.
                                                </li>
                                                <li>
                                                    <i class="fa fa-check fa-lg tw-text-green-400"></i>
                                                    <span class="tw-font-bold">@{{ activities.todosCompleted }}</span> @{{ pluralize('Todo', activities.todosCompleted) }} completed.
                                                </li>
                                                <li>
                                                    <i class="fa fa-check fa-lg tw-text-green-400"></i>
                                                    <span class="tw-font-bold">@{{ activities.todosInProgress }}</span> @{{ pluralize('Todo', activities.todosInProgress) }} in progress.
                                                </li>
                                                <li>
                                                    <i class="fa fa-check fa-lg tw-text-green-400"></i>
                                                    Participated in <span class="tw-font-bold">@{{ activities.projectsParticipatedIn }}</span> @{{ pluralize('Project', activities.projectsParticipatedIn) }}.
                                                </li>
                                                <li>
                                                    <i class="fa fa-check fa-lg tw-text-green-400"></i>
                                                    Participated in <span class="tw-font-bold">@{{ activities.todosParticipatedIn }}</span> @{{ pluralize('Todo', activities.todosParticipatedIn) }}.
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </activities>
@endsection
