import axios from 'axios';

const baseUrl = "/api/";

export default {
    install: function (Vue, options) {
        if (Vue.prototype.$stateSync) {
            return;
        }

        Vue.prototype['$stateSync'] = {
            getBoardColumns: async function () {
                return await axios.get(baseUrl + "board/get");
            },
            dumpSql: async function () {
                return await axios.get(baseUrl + "state/dump");
            },

            postColumn: async function ({name, index}) {
                return await axios.post(baseUrl + "column/post", {
                    name,
                    index
                });
            },
            editColumn: async function ({name, index}) {
                return await axios.put(baseUrl + "column/edit", {
                    name,
                    index
                });
            },
            moveColumn: async function ({oldIndex, index}) {
                return await axios.put(baseUrl + "column/move", {
                    oldIndex,
                    index
                });
            },
            deleteColumn: async function ({index}) {
                return await axios.delete(baseUrl + "column/delete", {
                    data: {
                        index
                    }
                });
            },

            postCard: async function ({name, description, index, columnIndex}) {
                return await axios.post(baseUrl + "card/post", {
                    name,
                    description,
                    index,
                    columnIndex
                });
            },
            editCard: async function ({name, description, index, columnIndex}) {
                return await axios.put(baseUrl + "card/edit", {
                    name,
                    description,
                    index,
                    columnIndex
                });
            },
            moveCard: async function ({oldIndex, oldColumnIndex, index, columnIndex}) {
                return await axios.put(baseUrl + "card/move", {
                    oldIndex,
                    oldColumnIndex,
                    index,
                    columnIndex
                });
            },
            deleteCard: async function ({index, columnIndex}) {
                return await axios.delete(baseUrl + "card/delete", {
                    data: {
                        index,
                        columnIndex
                    }
                });
            },
        };
    }
}
