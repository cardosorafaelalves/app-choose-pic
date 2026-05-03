// Client-side UploadSocket helper using socket.io-client to upload multiple files in chunks
// Usage example:
// const uploader = new UploadSocket('http://localhost:6000');
// uploader.on('progress', ({fileId, percent}) => { /* update UI */ });
// uploader.on('finished', ({fileId, publicUrl}) => { /* done */ });
// uploader.uploadFiles(fileList);

import { io } from 'socket.io-client';

export class UploadSocket {
  constructor(socketUrl, options = {}) {
    this.socket = io(socketUrl, options);
    this.chunkSize = options.chunkSize || 256 * 1024; // 256KB
    this.listeners = {
      progress: [],
      started: [],
      finished: [],
      error: [],
    };

    this.socket.on('connect', () => console.log('socket connected', this.socket.id));
    this.socket.on('upload-progress', (payload) => this.emitLocal('progress', payload));
    this.socket.on('upload-started', (payload) => this.emitLocal('started', payload));
    this.socket.on('upload-finished', (payload) => this.emitLocal('finished', payload));
    this.socket.on('upload-error', (payload) => this.emitLocal('error', payload));
  }

  on(event, fn) {
    if (this.listeners[event]) this.listeners[event].push(fn);
  }

  off(event, fn) {
    if (!this.listeners[event]) return;
    this.listeners[event] = this.listeners[event].filter((f) => f !== fn);
  }

  emitLocal(event, payload) {
    (this.listeners[event] || []).forEach((fn) => {
      try { fn(payload); } catch (e) { console.error('listener error', e); }
    });
  }

  async uploadFiles(fileList, destinationPath = '') {
    const files = Array.from(fileList);
    const promises = files.map((file) => this.uploadFile(file, destinationPath));
    return Promise.all(promises);
  }

  async uploadFile(file, destinationPath = '') {
    const fileId = this._uuid();
    const meta = {
      fileId,
      fileName: file.name,
      fileSize: file.size,
      mimeType: file.type || 'application/octet-stream',
      destinationPath
    };

    // Notify server that upload is starting
    this.socket.emit('start-upload', meta);

    // Read file in slices and send chunks
    let offset = 0;
    while (offset < file.size) {
      const slice = file.slice(offset, offset + this.chunkSize);
      const base64 = await this._readBlobAsBase64(slice);
      // base64 has data:<type>;base64,XXXX - strip prefix if present
      const commaIndex = base64.indexOf(',');
      const payloadBase64 = commaIndex !== -1 ? base64.slice(commaIndex + 1) : base64;
      this.socket.emit('upload-chunk', { fileId, chunk: payloadBase64 });
      offset += this.chunkSize;

      // Optionally we can wait for server ack or rely on server-side progress events
    }

    // Tell server to finalize
    this.socket.emit('finish-upload', { fileId });

    // Return a small promise that resolves when finished event comes back
    return new Promise((resolve, reject) => {
      const onFinished = (payload) => {
        if (payload.fileId === fileId) {
          this.off('finished', onFinished);
          this.off('error', onError);
          resolve(payload);
        }
      };
      const onError = (payload) => {
        if (payload.fileId === fileId) {
          this.off('finished', onFinished);
          this.off('error', onError);
          reject(new Error(payload.message || 'Upload error'));
        }
      };
      this.on('finished', onFinished);
      this.on('error', onError);
    });
  }

  _readBlobAsBase64(blob) {
    return new Promise((resolve, reject) => {
      const reader = new FileReader();
      reader.onload = () => resolve(reader.result);
      reader.onerror = reject;
      reader.readAsDataURL(blob);
    });
  }

  _uuid() {
    // simple UUID v4
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
      const r = (Math.random() * 16) | 0,
        v = c === 'x' ? r : (r & 0x3) | 0x8;
      return v.toString(16);
    });
  }
}
