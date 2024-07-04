<template>
    <form action="">

        <input
        type="text"
        placeholder="Serach"
        class="form_control"
        v-model="search"
         @input="fetchAll"
        />
        <button class="btn btn-warning btn-sm mr-2" @change="fetchAll">
            Search
        </button>
    </form>

    <div>
        <div class="form-group">
            <label for="name">Name </label>
            <input
                type="text"
                id="name"
                placeholder="Enter Name"
                class="form_control"
                v-model="item.name"
            />
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input
                type="text"
                id="phone"
                placeholder="Enter Phone"
                class="form_control"
                v-model="item.phone"
            />
        </div>
        <button class="btn btn-success btn-block" @click="save">
            {{ isEditting ? "Update" : "Save" }}
        </button>
        <div class="col-md-6 mt-3" v-if="lists.length > 0">
            <h2 class="text-center">Telephone Numbers</h2>
            <ul class="list-group" v-for="item in lists" :key="item.id">
                <li class="list-group-item">
                    {{ item.name }} {{ item.phone }}
                </li>
                <span class="float-right">
                    <button
                        class="btn btn-warning btn-sm mr-2"
                        @click="editTel(item)"
                    >
                        Edit
                    </button>
                    <button
                        class="btn btn-danger btn-sm mr-2"
                        @click="deleteTel(item.id)"
                    >
                        Delete
                    </button>
                </span>
            </ul>
        </div>

        <div class="col-md-6 mt-3" v-else>
            <h2>No Directory</h2>
        </div>
    </div>
</template>
<script>
import axios from "axios";

export default {
    name: "Directory",
    data() {
        return {
            search: "",
            lists: [],
            item: {
                name: "",
                phone: "",
            },
            temp_id: null,
            isEditting: false,
        };
    },
    mounted() {
        this.fetchAll();
    },

    methods: {
        fetchAll(e) {

            axios
            .get("/tel?search=" + this.search)
            .then((res) => (this.lists = res.data));
            e.preventDefault();
        },
        async save() {
            let method = axios.post;
            let url = "/tel";
            if (this.isEditting) {
                method = axios.put;
                url = `/tel/${this.temp_id}`;
            }
            try {
                await method(url, this.item).then((res) => {
                    this.fetchAll(),
                    this.item = {
                        name: "",
                        phone: "",
                    };
                    this.temp_id = null;
                    this.isEditting = false;

                });
            } catch (e) {
                console.log(e);
            }
        },
        deleteTel(id) {
            axios.delete(`/tel/${id}`).then((res) => this.fetchAll());
        },
        editTel(tel) {
            this.item = {
                name: tel.name,
                phone: tel.phone,
            };
            (this.temp_id = tel.id), (this.isEditting = true);
        },
    },
};
</script>
