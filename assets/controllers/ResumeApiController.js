import axios from "axios";

const API_CV = '/api/cv/';

export const resumeApi = {
    getAll: () => axios.get(
        API_CV
    ),

    getById: id => axios.get(
        API_CV + id
    ),

    add: summary => axios.post(
        API_CV + 'add',
        toJson(summary)
    ),

    edit: (id, summary) => axios.post(
        API_CV + id + '/edit',
        toJson(summary)
    ),

    statusUpdate: (id, newStatus) => axios.post(
        API_CV + id + '/status/update',
        toJson({
            status: newStatus
        })
    ),
};

function toJson(data) {
    return JSON.stringify(data, (k, v) => {
        if (v === '') {
            return undefined;
        } else {
            return v;
        }
    });
}