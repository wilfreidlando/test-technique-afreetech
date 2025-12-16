import { openDB } from 'idb';
import { DB_NAME, STORE_NAME } from '../config/api';

const initDB = async () => {
  return openDB(DB_NAME, 1, {
    upgrade(db) {
      if (!db.objectStoreNames.contains(STORE_NAME)) {
        db.createObjectStore(STORE_NAME);
      }
    },
  });
};

export const storage = {
  async saveToken(token) {
    const db = await initDB();
    await db.put(STORE_NAME, token, 'token');
  },
  async getToken() {
    const db = await initDB();
    return await db.get(STORE_NAME, 'token');
  },
  async removeToken() {
    const db = await initDB();
    await db.delete(STORE_NAME, 'token');
  },
};