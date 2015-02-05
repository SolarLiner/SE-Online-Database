using System;
using System.Collections.Generic;
using System.Collections.Specialized;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Net;
using System.Web.Script.Serialization;
namespace DBsync
{
    class Program
    {
        static void Main(string[] args)
        {
            NameValueCollection values = new NameValueCollection();

            // Test
            //values.Add("MODE", "SET");
            //values.Add("LOCNAME", "Nisaba");
            //values.Add("NAME", "RS 8409-2299-7-136965-374 8.3");
            //values.Add("PARENT", "RS 8409-2299-7-136965-374 8");
            //values.Add("PIONEERNAME", "Rodrigo");
            //values.Add("DATE", String.Format("{0:Y.m.d H:i:s}", DateTime.UtcNow));
            //values.Add("DESCR", "{7D9FC518-6E03-4C52-B34A-EF0C7328F796}");
            values.Add("MODE", "GET");
            values.Add("ID", "1");

            DBclass data;

            using(var client = new WebClient())
            {
                byte[] contents = client.UploadValues("http://localhost:8080/index.php", values);

                var serializer = new JavaScriptSerializer();

                data = serializer.Deserialize<DBclass>(Encoding.ASCII.GetString(contents));
                //data = Encoding.ASCII.GetString(contents);
            }

            Console.WriteLine(data);
            System.IO.File.WriteAllText("result.html", data.ToString());
        }
    }
}
