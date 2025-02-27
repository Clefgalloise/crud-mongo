import {detect} from './../../utils/tf';

const state = {
    data: [],
    current: null
};

const getters = {
    images: state => {
        return state.data;
    },
    exist: state => {
        return image => {
            return state.data.filter(item => item._id !== image).length > 0;
        }
    },
    current: state => {
        return state.current;
    }
};

const actions = {
    /**
     * Create new images.
     *
     * @param commit
     * @param {FileList} files
     * @returns {Promise<void>}
     */
    create: async ({commit}, files) => {
        let formData = new FormData();
        let predictions = new Object();

        for (let i = 0; i < files.length; i++) {
            predictions['image_' + i] = await detect(files[i]);

            formData.append('image_' + i, files[i]);
        }

        formData.append('predictions', JSON.stringify(predictions));

        let res = await axios.post('/api/images', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });

        if (res.status === 200 && res.data.success === true) {
            commit('addImages', res.data);
        }
    },
    fetchImage: async ({commit}, image) => {
        let res = await axios.get('/api/images/' + image);

        if (res.status === 200 && res.data.success === true) {
            commit('setCurrent', res.data);
        }
    },
    fetchImages: async ({commit}) => {
        let res = await axios.get('/api/images/all');

        if (res.status === 200 && res.data.success === true) {
            commit('setImages', res.data);
        }
    },
    deleteImage: async ({commit}, image) => {
        let res = await axios.delete('/api/images/' + image);

        if (res.status === 200 && res.data.success === true) {
            commit('deleteImage', image);
        }
    }
};

const mutations = {
    setCurrent: (state, {data}) => {
        state.current = data;
    },
    setImages: (state, {data}) => {
        state.data = data;
    },
    deleteImage: (state, image) => {
        state.data = state.data.filter(item => item._id !== image);

        if (state.current._id === image) {
            state.current = null;
        }
    },
    addImages: (state, {data}) => {
        state.data = [...data, ...state.data];
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
