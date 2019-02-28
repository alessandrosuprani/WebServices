using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Navigation;
using System.Windows.Shapes;
using System.Net.Http;
using System.IO;

namespace SOAPClient
{
    /// <summary>
    /// Logica di interazione per MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        public MainWindow()
        {
            InitializeComponent();
            
        }
        
        //posso usare using se è presete metodo dispose
        async static void GetRequest(string url)
        {
            using (HttpClient client = new HttpClient())
            {
                // Richiesta al server
                using (HttpResponseMessage response = await (client.GetAsync(url)))
                {
                    // Estrazione del contenuto
                    using (HttpContent content = response.Content)
                    {
                        string myContent = await (content.ReadAsStringAsync());

                        MessageBox.Show(myContent);
                    }
                }
            }
        }

        //Importante: l'indirizzo della macchina server(10.13.100.27) è quello della mia macchina virtuale, va modificato quando viene usata una macchina virtuale diversa

        //QUERY N°1
        private void Button_Click(object sender, RoutedEventArgs e)
        {
            string url = @"http://10.13.100.27/Server/index.php/" + "?index=1";

            GetRequest(url);
        }

        //QUERY N°2
        private void Button_Click_1(object sender, RoutedEventArgs e)
        {
            string url = @"http://10.13.100.27/Server/index.php/" + "?index=2";

            GetRequest(url);
        }

        //QUERY N°3, si effettuano i controlli sul corretto inserimento delle date
        private void Button_Click_2(object sender, RoutedEventArgs e)
        {
            string start = txt_start.Text;
            string end = txt_end.Text;

            int day = 0, month = 0, year = 0;

            string[] start_date = start.Split('/');
            string[] end_date = end.Split('/');

            if((start_date.Length != 3) || (end_date.Length !=3))
            {
                MessageBox.Show("Inserire le date nel formato corretto (gg/mm/aaaa)");   
            }
            else
            { 
            bool test_day = int.TryParse(start_date[0], out day);
            bool test_month = int.TryParse(start_date[1], out month);
            bool test_year = int.TryParse(start_date[2], out year);

                if (!test_day || !test_month || !test_year)
                    MessageBox.Show("Controlla la data di inizio");
                else if ((day < 0 || day > 31) || (month < 0) || (month > 12) || (year < 1900 || year > 2019))
                    MessageBox.Show("Formato errato nella data di inizio (0<giorno<30, 0<mese<12, 1900<anno<2019)");
                else
                {
                    bool test_day_end = int.TryParse(end_date[0], out day);
                    bool test_month_end = int.TryParse(end_date[1], out month);
                    bool test_year_end = int.TryParse(end_date[2], out year);

                    if (!test_day_end || !test_month_end || !test_year_end)
                        MessageBox.Show("Controlla la data di fine");
                    else if ((day < 0 || day > 31) || (month < 0) || (month > 12) || (year < 1900 || year > 2019))
                        MessageBox.Show("Formato errato nella data di fine (0<giorno<30, 0<mese<12, 1900<anno<2019)");
                    else
                    {
                        string url = @"http://10.13.100.27/Server/index.php/" + "?index=3&start_data=" + start + "&end_data=" + end;

                        GetRequest(url);
                    }
                }
            }
        }

        //QUERY N°4, si effettua il controllo sulla correttezza dell'indice
        private void Btn_query4_Click(object sender, RoutedEventArgs e)
        {
            int codice = 0;
            string text = txt_codice.Text;
            bool test = int.TryParse(text, out codice);
            if (!test)
                MessageBox.Show("Inserisci un valore");
            else if (codice <= 0 || codice > 10)
                MessageBox.Show("Inserisci un codice valido");
            else
            {
                string url = @"http://10.13.100.27/Server/index.php/" + "?index=4&codice=" + codice;

                GetRequest(url);
            }
        }
    }
}
