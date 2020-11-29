self.addEventListener('install', () => self.skipWaiting())

self.addEventListener('activate', () => {
  self.clients.matchAll({ type: 'window' }).then(windowClients => {
    for (const windowClient of windowClients) {
      windowClient.navigate(windowClient.url)
    }
  })
})