import threading
import ssl
 
from http.server import BaseHTTPRequestHandler, ThreadingHTTPServer
 
 
class HelloHTTPRequestHandler(BaseHTTPRequestHandler):
 
  def _set_response(self):
    self.send_response(200)
    self.send_header('Content-type', 'text/html')
    self.send_header('Access-Control-Allow-Origin', '*')
    self.end_headers()

  def do_OPTIONS(self):
    #print("OPTIONS request,\nPath: %s\nHeaders:\n%s\n", str(self.path), str(self.headers))
    self.send_response(200)
    self.send_header('Allow', 'OPTIONS, GET, POST')
    self.send_header('Access-Control-Allow-Origin', '*')
    self.send_header('Access-Control-Allow-Headers', '*')
    self.send_header('Access-Control-Allow-Methods', 'OPTIONS, GET, POST')
    self.end_headers()
    self.wfile.write("GET request for {}".format(self.path).encode('utf-8'))

  def do_GET(self):
    print("GET request,\nPath: ", str(self.path))
    self._set_response()
    self.wfile.write("GET request for {}".format(self.path).encode('utf-8'))

  def do_POST(self):
    content_length = int(self.headers['Content-Length']) # <--- Gets the size of data
    post_data = self.rfile.read(content_length) # <--- Gets the data itself
    print(post_data.decode('utf-8'))
    #print("POST request,\nPath: %s\nHeaders:\n%s\n\nBody:\n%s\n", str(self.path), str(self.headers), post_data.decode('utf-8'))
    self._set_response()
    self.wfile.write("POST request for {}".format(self.path).encode('utf-8'))
  
  def log_message(self, format, *args):
    return
 
 
def serve(addr, port):
  with ThreadingHTTPServer((addr, port), HelloHTTPRequestHandler) as server:
    #server.socket = ssl.wrap_socket(server.socket, certfile='./server.pem', server_side=True)
    server.serve_forever(poll_interval=None)
 
 
if __name__ == '__main__':
 
  addr, port = ("10.0.2.21", 8080)
 
  threading.Thread(target=serve, args=(addr, port), daemon=True).start()
 
  try:
    while True:
      # handle Ctrl+C
      input()
 
  except KeyboardInterrupt:
    pass