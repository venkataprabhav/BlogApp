const BASE_URL = 'http://127.0.0.1:8000/api';

function getToken() {
  return localStorage.getItem('token');
}

function authHeaders() {
  return {
    'Content-Type': 'application/json',
    Authorization: `Bearer ${getToken()}`,
  };
}

async function request(method, path, body = null, auth = true) {
  const options = {
    method,
    headers: auth ? authHeaders() : { 'Content-Type': 'application/json' },
  };
  if (body) options.body = JSON.stringify(body);

  const res = await fetch(`${BASE_URL}${path}`, options);
  const data = await res.json().catch(() => null);

  if (!res.ok) {
    const message = data?.message || `Request failed: ${res.status}`;
    throw new Error(message);
  }
  return data;
}

// Auth
export const register = (name, email, password, password_confirmation) =>
  request('POST', '/register', { name, email, password, password_confirmation }, false);

export const login = (email, password) =>
  request('POST', '/login', { email, password }, false);

export const logout = () => request('POST', '/logout');

export const getMe = () => request('GET', '/me');

// Notes
export const getNotes = () => request('GET', '/posts');

export const getNote = (id) => request('GET', `/posts/${id}`);

export const createNote = (body) => request('POST', '/posts', { body });

export const updateNote = (id, body) => request('PUT', `/posts/${id}`, { body });

export const deleteNote = (id) => request('DELETE', `/posts/${id}`);

// Votes
export const likeNote = (id) => request('POST', `/posts/${id}/vote/like`);

export const dislikeNote = (id) => request('POST', `/posts/${id}/vote/dislike`);
