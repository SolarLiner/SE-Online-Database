using System;
using System.Collections.Generic;
using System.Collections.Specialized;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace DBsync
{
    public static class Misc
    {
        public static string ToScript(DBclass input)
        {
            string result = "PObject\n{\n";

            result += "\tLocName\t\"" + input.LocName + "\"\n";
            result += "\tName\t\"" + input.Name + "\"\n";
            result += "\tParent\t\"" + input.Parent + "\"\n";
            result += "\tPioneer\t\"" + input.PioneerName + "\"\n";
            result += "\tDate\t\"" + input.Date.ToString("yyyy.mm.dd HH:mm:ss") + "\"\n";
            result += "\tDescr\t\"" + input.Descr + "\"\n";

            result += "}\n";

            return result;
        }
    }
}
