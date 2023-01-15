import { writable, get } from 'svelte/store'

export let data = writable({})
export let getdata = get(data);