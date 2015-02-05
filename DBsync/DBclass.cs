using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace DBsync
{
    public struct DBclass
    {
        public string Name { get; set; }
        public string LocName { get; set; }
        public string PioneerName { get; set; }
        public string Parent { get; set; }
        public DateTime Date { get; set; }
        public string Descr { get; set; }
    }
}
