import LightPick from 'lightpick';
import 'lightpick/css/lightpick.css';
import pluralize from 'pluralize';

Vue.component('activities', {
    props: ['user', 'account', 'developers'],
    data: () => ({
        selectedDeveloper: null,
        datepicker: null,
        startDate: null,
        endDate: null,
        activitiesDuration: null,
        projects: {
            data: [],
            currentPage: 0,
            isItLatestPage: true
        },
        todos: {
            data: [],
            currentPage: 0,
            isItLatestPage: true
        },
        activities: null
    }),
    mounted() {
        // Define the first developer as selectedDeveloper
        this.selectedDeveloper = this.developers[0].id;

        this.setupLightPick();
    },
    methods: {
        setupLightPick() {
            this.datepicker = new LightPick({
                field: document.getElementById('datepicker'),
                singleDate: false,
                inline: true,
                hoveringTooltip: false,
                parentEl: '.datepicker-section',
                onSelect: (start, end) => {
                    let str = '';
                    str += start ? start.format('YYYY/MM/DD') + ' to ' : '';
                    str += end ? end.format('YYYY/MM/DD') : '...';

                    this.activitiesDuration = str;
                    this.startDate = start ? start.format('YYYY/MM/DD') : null;
                    this.endDate = end ? end.format('YYYY/MM/DD') : null;
                }
            })
        },

        getData() {
            this.fetchProjects(true);
            this.fetchTodos(true);
            this.getActivities()
        },

        async fetchProjects(refreshData = false) {
            if (refreshData)
            {
                this.projects = this.getFreshData()
            }

            await axios.get(`/developers/${this.selectedDeveloper}/activities/projects`, {
                params: {
                    startDate: this.startDate,
                    endDate: this.endDate,
                    page: this.projects.currentPage+1
                }
            })
                .then((res) => {
                    this.projects.data.push(...res.data.data);
                    this.projects.currentPage = res.data.current_page;
                    this.projects.isItLatestPage = res.data.last_page <= res.data.current_page;
                })
        },

        async fetchTodos(refreshData = false) {
            if (refreshData)
            {
                this.todos = this.getFreshData()
            }

            await axios.get(`/developers/${this.selectedDeveloper}/activities/todos`, {
                params: {
                    startDate: this.startDate,
                    endDate: this.endDate,
                    page: this.todos.currentPage+1
                }
            })
                .then((res) => {
                    this.todos.data.push(...res.data.data);
                    this.todos.currentPage = res.data.current_page;
                    this.todos.isItLatestPage = res.data.last_page <= res.data.current_page;
                })
        },

        async getActivities() {
            await axios.get(`/developers/${this.selectedDeveloper}/activities`, {
                params: {
                    startDate: this.startDate,
                    endDate: this.endDate
                }
            })
                .then((res) => {
                    this.activities = res.data.data;
                })
        },

        pluralize(string, value) {
            return pluralize(string, value);
        },

        getFreshData() {
            return {
                data: [],
                currentPage: 0,
                isItLatestPage: true
            }
        }
    }
});
