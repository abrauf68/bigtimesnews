<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Category 4: Business & Economy (10 posts)
        $businessPosts = [
            [
                'title' => 'Global Markets Rally as Inflation Shows Signs of Cooling',
                'content' => 'Stock markets worldwide surged following promising inflation data that suggests central banks may pause interest rate hikes. The Dow Jones jumped 500 points, while European and Asian markets also saw significant gains.',
                'read_time' => '4 min read',
                'meta_title' => 'Global Markets Rally on Cooling Inflation',
                'meta_description' => 'Stock markets surge as inflation shows signs of cooling'
            ],
            [
                'title' => 'Cryptocurrency Regulation: New Framework Proposed by G20 Nations',
                'content' => 'The G20 nations have unveiled a comprehensive framework for cryptocurrency regulation, aiming to balance innovation with consumer protection. The proposal includes stricter KYC requirements and capital reserves for exchanges.',
                'read_time' => '5 min read',
                'meta_title' => 'G20 Nations Propose New Crypto Regulation Framework',
                'meta_description' => 'Comprehensive crypto regulations unveiled by G20'
            ],
            [
                'title' => 'Remote Work Revolution: Companies Downsize Office Spaces by 40%',
                'content' => 'Major corporations are permanently reducing their office footprint as remote work becomes the new normal. This shift is reshaping commercial real estate markets and urban economies across the globe.',
                'read_time' => '4 min read',
                'meta_title' => 'Remote Work Causes 40% Office Space Reduction',
                'meta_description' => 'Companies permanently downsize offices as remote work persists'
            ],
            [
                'title' => 'Electric Vehicle Sales Surpass Gasoline Cars for First Time in Europe',
                'content' => 'In a historic milestone, electric vehicle sales have overtaken traditional gasoline-powered cars in European markets. Government incentives and improved charging infrastructure drove the shift.',
                'read_time' => '5 min read',
                'meta_title' => 'EV Sales Overtake Gasoline Cars in Europe',
                'meta_description' => 'Historic milestone as electric vehicles lead European car sales'
            ],
            [
                'title' => 'AI Startup Acquired for $1.2 Billion in Largest Tech Deal This Year',
                'content' => 'A promising artificial intelligence startup has been acquired in a blockbuster $1.2 billion deal, marking the largest tech acquisition of the year. The company\'s proprietary algorithms show promise in healthcare applications.',
                'read_time' => '4 min read',
                'meta_title' => 'AI Startup Acquired for $1.2 Billion',
                'meta_description' => 'Record-breaking tech acquisition shakes up AI industry'
            ],
            [
                'title' => 'Federal Reserve Announces Surprise Rate Cut to Boost Economy',
                'content' => 'The Federal Reserve has surprised markets with an emergency interest rate cut aimed at stimulating economic growth. This marks the first unscheduled rate adjustment in over a decade.',
                'read_time' => '4 min read',
                'meta_title' => 'Fed Announces Surprise Interest Rate Cut',
                'meta_description' => 'Emergency rate cut aims to stimulate economic growth'
            ],
            [
                'title' => 'Sustainable Investing: ESG Funds Outperform Traditional Portfolios',
                'content' => 'Environmental, Social, and Governance (ESG) funds have outperformed traditional investment portfolios for the third consecutive year, proving that responsible investing delivers strong returns.',
                'read_time' => '5 min read',
                'meta_title' => 'ESG Funds Outperform Traditional Investments',
                'meta_description' => 'Sustainable investing delivers superior returns for third year'
            ],
            [
                'title' => 'Gig Economy Workers Win Landmark Benefits Case in Supreme Court',
                'content' => 'The Supreme Court has ruled in favor of gig economy workers, granting them access to benefits traditionally reserved for full-time employees. The decision affects millions of workers nationwide.',
                'read_time' => '6 min read',
                'meta_title' => 'Gig Workers Win Landmark Benefits Case',
                'meta_description' => 'Supreme Court ruling grants benefits to millions of gig workers'
            ],
            [
                'title' => 'Luxury Brand Reports Record Profits Despite Economic Slowdown',
                'content' => 'A leading luxury goods manufacturer has reported record quarterly profits, defying broader economic trends. Analysts attribute the success to strong demand from Asian markets and successful digital transformation.',
                'read_time' => '4 min read',
                'meta_title' => 'Luxury Brand Posts Record Profits',
                'meta_description' => 'High-end retailer defies economic slowdown with strong earnings'
            ],
            [
                'title' => 'Supply Chain Innovation: Robots and AI Transform Warehouse Operations',
                'content' => 'Cutting-edge robotics and artificial intelligence are revolutionizing supply chain management, with automated warehouses achieving 50% faster processing times and significantly reduced errors.',
                'read_time' => '5 min read',
                'meta_title' => 'AI and Robots Transform Supply Chain Operations',
                'meta_description' => 'Warehouse automation boosts efficiency by 50%'
            ],
        ];

        // Category 5: Entertainment (10 posts)
        $entertainmentPosts = [
            [
                'title' => 'Streaming Wars: New Platform Launches with Exclusive Celebrity Content',
                'content' => 'A major tech company has entered the streaming market with a star-studded lineup of exclusive content. The platform features original series from top directors and interactive experiences.',
                'read_time' => '4 min read',
                'meta_title' => 'New Streaming Platform Launches with Celebrity Content',
                'meta_description' => 'Tech giant enters streaming wars with exclusive celebrity shows'
            ],
            [
                'title' => 'Music Festival Draws Record Crowd of 500,000 Fans',
                'content' => 'One of the world\'s largest music festivals concluded with record-breaking attendance, featuring performances from over 200 artists. The event generated an estimated $300 million for the local economy.',
                'read_time' => '5 min read',
                'meta_title' => 'Music Festival Breaks Records with 500,000 Attendees',
                'meta_description' => 'Historic turnout at world\'s largest music festival'
            ],
            [
                'title' => 'Award-Winning Director Announces Retirement After Final Masterpiece',
                'content' => 'An acclaimed film director known for multiple Oscar-winning films has announced their retirement following the release of what they call their "final masterpiece." The director leaves behind a legacy of 30 influential films.',
                'read_time' => '5 min read',
                'meta_title' => 'Legendary Director Retires After Final Film',
                'meta_description' => 'Acclaimed filmmaker ends illustrious career with masterpiece'
            ],
            [
                'title' => 'Video Game Adaptation Breaks Records as Most-Watched Series',
                'content' => 'A popular video game adaptation has become the most-watched series in streaming history, earning rave reviews from both critics and gamers. The show has already been renewed for two additional seasons.',
                'read_time' => '4 min read',
                'meta_title' => 'Video Game Adaptation Shatters Viewership Records',
                'meta_description' => 'Gaming adaptation becomes most-watched streaming series ever'
            ],
            [
                'title' => 'Reality TV Star Turned Producer Launches Production Company',
                'content' => 'A former reality television personality has launched their own production company, signing first-look deals with major streaming platforms. The company aims to champion diverse voices in entertainment.',
                'read_time' => '4 min read',
                'meta_title' => 'Reality Star Launches Production Company',
                'meta_description' => 'Former TV personality expands entertainment empire'
            ],
            [
                'title' => 'Broadway Returns: Ticket Sales Surpass Pre-Pandemic Levels',
                'content' => 'Broadway has fully recovered from pandemic-era closures, with ticket sales exceeding pre-2020 levels. Several new productions are breaking box office records and drawing diverse audiences.',
                'read_time' => '5 min read',
                'meta_title' => 'Broadway Ticket Sales Exceed Pre-Pandemic Levels',
                'meta_description' => 'Live theater makes triumphant return with record sales'
            ],
            [
                'title' => 'Comedian\'s Netflix Special Becomes Most-Viewed Stand-Up Special',
                'content' => 'A groundbreaking comedy special has become Netflix\'s most-watched stand-up performance, earning critical acclaim for its honest exploration of social issues while delivering laughs.',
                'read_time' => '4 min read',
                'meta_title' => 'Comedy Special Breaks Netflix Viewership Records',
                'meta_description' => 'Stand-up performance becomes streaming platform\'s most popular'
            ],
            [
                'title' => 'Animated Film Wins Top Prize at Major Festival for First Time',
                'content' => 'An animated feature has won the top award at a prestigious film festival for the first time in the event\'s history, signaling growing recognition for the art form in mainstream cinema.',
                'read_time' => '5 min read',
                'meta_title' => 'Animated Film Makes History with Festival Win',
                'meta_description' => 'First-ever animation to win top festival prize'
            ],
            [
                'title' => 'Pop Star\'s Surprise Album Release Breaks Streaming Records',
                'content' => 'A global pop superstar surprised fans with an unannounced album release, breaking first-day streaming records across all platforms. Critics praise the work as the artist\'s most personal to date.',
                'read_time' => '4 min read',
                'meta_title' => 'Surprise Album Release Shatters Streaming Records',
                'meta_description' => 'Pop star\'s unexpected album dominates global charts'
            ],
            [
                'title' => 'Podcast Network Acquired for $500 Million in Media Consolidation',
                'content' => 'A major podcast network has been acquired in a $500 million deal, reflecting the growing importance of audio content in the entertainment landscape. The network produces over 100 popular shows.',
                'read_time' => '4 min read',
                'meta_title' => 'Podcast Network Sold for $500 Million',
                'meta_description' => 'Major acquisition signals podcasting\'s mainstream dominance'
            ],
        ];

        // Category 6: Sports (10 posts)
        $sportsPosts = [
            [
                'title' => 'Underdog Team Wins World Series in Game 7 Thriller',
                'content' => 'In one of the most dramatic World Series finishes in history, the underdog team secured victory in extra innings of Game 7. The winning hit came with two outs in the bottom of the ninth.',
                'read_time' => '6 min read',
                'meta_title' => 'Underdog Wins World Series in Game 7 Thriller',
                'meta_description' => 'Historic comeback secures championship in extra innings'
            ],
            [
                'title' => 'Olympic Champion Announces Comeback After Four-Year Hiatus',
                'content' => 'A multiple Olympic gold medalist has announced their return to competition after a four-year break. The athlete cites renewed passion and unfinished business as motivation for the comeback.',
                'read_time' => '4 min read',
                'meta_title' => 'Olympic Champion Announces Comeback',
                'meta_description' => 'Legendary athlete returns after four-year retirement'
            ],
            [
                'title' => 'Soccer Star Signs Record-Breaking $500 Million Contract',
                'content' => 'A soccer superstar has signed the most lucrative contract in sports history, a $500 million deal spanning five seasons. The agreement includes significant commercial and image rights provisions.',
                'read_time' => '5 min read',
                'meta_title' => 'Soccer Star Signs $500 Million Contract',
                'meta_description' => 'Record-breaking deal makes athlete highest-paid in sports history'
            ],
            [
                'title' => 'Tennis Legend Wins Grand Slam at Age 40',
                'content' => 'A tennis icon has defied age and expectations by winning a Grand Slam tournament at 40 years old, becoming the oldest champion in the Open Era. The victory marks their 25th major title.',
                'read_time' => '5 min read',
                'meta_title' => '40-Year-Old Tennis Legend Wins Grand Slam',
                'meta_description' => 'Age-defying athlete becomes oldest champion in Open Era'
            ],
            [
                'title' => 'Basketball Rookie Breaks Longstanding Scoring Record',
                'content' => 'An 19-year-old rookie has broken a 40-year-old scoring record, announcing their arrival as the league\'s next superstar. The young player averaged 35 points per game in their debut season.',
                'read_time' => '4 min read',
                'meta_title' => 'Rookie Breaks 40-Year-Old Scoring Record',
                'meta_description' => 'Young superstar shatters historic NBA record'
            ],
            [
                'title' => 'Formula 1 Driver Wins Fourth Consecutive World Championship',
                'content' => 'A dominant Formula 1 driver has secured their fourth straight world championship, tying them with legendary drivers in the record books. The season featured 15 wins out of 22 races.',
                'read_time' => '5 min read',
                'meta_title' => 'F1 Driver Wins Fourth Straight Title',
                'meta_description' => 'Dominant season secures place among racing legends'
            ],
            [
                'title' => 'Golfer Completes Career Grand Slam with Masters Victory',
                'content' => 'An elite golfer has completed the career Grand Slam after winning the Masters in dramatic fashion, joining an exclusive club of only six players to achieve the feat.',
                'read_time' => '4 min read',
                'meta_title' => 'Golfer Completes Career Grand Slam',
                'meta_description' => 'Masters victory adds name to exclusive golf legends list'
            ],
            [
                'title' => 'Women\'s Sports League Secures Historic TV Rights Deal',
                'content' => 'A professional women\'s sports league has signed a landmark television rights deal worth $1 billion over five years, signaling growing investment and interest in women\'s athletics.',
                'read_time' => '5 min read',
                'meta_title' => 'Women\'s League Lands Historic TV Deal',
                'meta_description' => '$1 billion agreement marks turning point for women\'s sports'
            ],
            [
                'title' => 'Marathon World Record Broken by 30 Seconds',
                'content' => 'A long-distance runner has shattered the marathon world record by an astonishing 30 seconds, completing the 26.2-mile distance in under two hours and two minutes.',
                'read_time' => '4 min read',
                'meta_title' => 'Marathon World Record Shattered by 30 Seconds',
                'meta_description' => 'Athlete achieves unprecedented time in marathon history'
            ],
            [
                'title' => 'Controversial Overturn Leads to Rule Changes in Professional Sport',
                'content' => 'Following a highly controversial championship-deciding call, the league has announced immediate rule changes and implemented a new instant replay system to prevent future errors.',
                'read_time' => '6 min read',
                'meta_title' => 'Controversial Call Leads to Rule Changes',
                'meta_description' => 'League overhauls officiating system after championship dispute'
            ],
        ];

        // Category 7: Technology (10 posts)
        $technologyPosts = [
            [
                'title' => 'Quantum Computing Breakthrough Solves Decade-Long Problem in Minutes',
                'content' => 'Scientists have achieved a quantum computing milestone, solving a complex problem that would take traditional supercomputers thousands of years in just minutes. The breakthrough could revolutionize drug discovery.',
                'read_time' => '6 min read',
                'meta_title' => 'Quantum Computer Solves Decade Problem in Minutes',
                'meta_description' => 'Breakthrough achievement accelerates quantum computing timeline'
            ],
            [
                'title' => 'Smart Glasses 2.0: Lightweight Design with Full AR Capabilities',
                'content' => 'A tech giant has unveiled next-generation smart glasses weighing just 50 grams but offering full augmented reality capabilities, including holographic displays and gesture control.',
                'read_time' => '4 min read',
                'meta_title' => 'Next-Gen Smart Glasses Feature Full AR Capabilities',
                'meta_description' => 'Lightweight AR glasses represent major tech advancement'
            ],
            [
                'title' => '5G Expansion Complete: Full Coverage Reaches Rural Areas',
                'content' => 'The nationwide 5G rollout has been completed, bringing high-speed connectivity to even the most remote rural areas. The expansion promises to bridge the digital divide and enable new technologies.',
                'read_time' => '4 min read',
                'meta_title' => '5G Expansion Brings Coverage to Rural Areas',
                'meta_description' => 'Nationwide rollout completes digital connectivity infrastructure'
            ],
            [
                'title' => 'Cybersecurity Alert: New Protection Software Blocks Advanced Threats',
                'content' => 'Security researchers have developed revolutionary protection software that uses AI to predict and block previously unknown cyber threats with 99.9% accuracy.',
                'read_time' => '5 min read',
                'meta_title' => 'AI-Powered Security Software Blocks Advanced Threats',
                'meta_description' => 'Next-gen cybersecurity achieves 99.9% threat detection rate'
            ],
            [
                'title' => 'Space Internet: Satellite Constellation Now Serving 1 Million Users',
                'content' => 'A space-based internet service has reached one million subscribers worldwide, providing high-speed connectivity to areas without traditional infrastructure. The constellation now includes 3,000 satellites.',
                'read_time' => '5 min read',
                'meta_title' => 'Space Internet Service Reaches 1 Million Users',
                'meta_description' => 'Satellite constellation bridges global connectivity gaps'
            ],
            [
                'title' => 'Biometric Payments Roll Out Nationwide: No Cards or Phones Needed',
                'content' => 'A national payment system using fingerprint and palm recognition has launched, allowing customers to pay without cards, phones, or wallets. The system prioritizes security and convenience.',
                'read_time' => '4 min read',
                'meta_title' => 'Biometric Payment System Launches Nationwide',
                'meta_description' => 'Touch-and-pay technology eliminates need for cards and phones'
            ],
            [
                'title' => 'Drone Delivery Service Expands to 50 New Cities',
                'content' => 'A leading logistics company has expanded its drone delivery service to 50 additional cities, promising 30-minute delivery for thousands of products. The service has completed over 1 million successful deliveries.',
                'read_time' => '4 min read',
                'meta_title' => 'Drone Delivery Expands to 50 New Cities',
                'meta_description' => 'Autonomous delivery service reaches major expansion milestone'
            ],
            [
                'title' => 'Smart Home Standard Unifies Competing Platforms',
                'content' => 'Major tech companies have agreed on a unified smart home standard, ending years of compatibility issues. The new standard will allow devices from different manufacturers to work seamlessly together.',
                'read_time' => '5 min read',
                'meta_title' => 'New Standard Unifies Smart Home Platforms',
                'meta_description' => 'Industry agreement ends compatibility headaches for consumers'
            ],
            [
                'title' => 'Electric Aircraft Completes First Commercial Test Flight',
                'content' => 'An all-electric passenger aircraft has successfully completed its first commercial test flight, marking a major step toward zero-emission aviation. The 30-minute flight carried 50 passengers.',
                'read_time' => '5 min read',
                'meta_title' => 'Electric Aircraft Completes Commercial Test Flight',
                'meta_description' => 'Zero-emission plane represents future of sustainable aviation'
            ],
            [
                'title' => 'Brain-Computer Interface Allows Paralyzed Patient to Type by Thought',
                'content' => 'A paralyzed individual has typed at 90 characters per minute using only their thoughts, thanks to an advanced brain-computer interface. The breakthrough offers hope for millions with mobility impairments.',
                'read_time' => '6 min read',
                'meta_title' => 'Brain-Computer Interface Enables Thought Typing',
                'meta_description' => 'Paralyzed patient achieves record typing speed using only thoughts'
            ],
        ];

        // Category 9: Health (10 posts)
        $healthPosts = [
            [
                'title' => 'Personalized Cancer Vaccine Shows Promise in Clinical Trials',
                'content' => 'A personalized mRNA vaccine tailored to individual patients\' tumors has shown remarkable results in clinical trials, with 80% of participants showing no cancer recurrence after two years.',
                'read_time' => '6 min read',
                'meta_title' => 'Personalized Cancer Vaccine Shows Trial Success',
                'meta_description' => 'mRNA vaccine demonstrates 80% recurrence prevention rate'
            ],
            [
                'title' => 'Meditation App Study Shows Reduced Anxiety in 8 Weeks',
                'content' => 'A new study confirms that using a popular meditation app for just 10 minutes daily significantly reduces anxiety and improves sleep quality within eight weeks.',
                'read_time' => '4 min read',
                'meta_title' => 'Meditation App Reduces Anxiety in 8 Weeks',
                'meta_description' => 'Study proves mental health benefits of daily mindfulness practice'
            ],
            [
                'title' => 'Wearable Device Detects Illness Before Symptoms Appear',
                'content' => 'A smart wearable device can now predict illness up to 48 hours before symptoms appear by analyzing subtle changes in heart rate, temperature, and sleep patterns.',
                'read_time' => '5 min read',
                'meta_title' => 'Wearable Device Predicts Illness Before Symptoms',
                'meta_description' => 'Early warning system detects sickness days in advance'
            ],
            [
                'title' => 'Gene Editing Therapy Cures Rare Genetic Disorder',
                'content' => 'Doctors have successfully used CRISPR gene editing to cure a rare genetic disorder, marking the first time the technique has eliminated disease symptoms entirely in human patients.',
                'read_time' => '6 min read',
                'meta_title' => 'Gene Editing Cures Rare Genetic Disorder',
                'meta_description' => 'CRISPR therapy eliminates disease in landmark treatment'
            ],
            [
                'title' => 'Nutrition Breakthrough: New Guidelines for Optimal Aging',
                'content' => 'Researchers have released updated nutrition guidelines based on a decade-long study of centenarians, identifying specific dietary patterns associated with healthy aging and cognitive function.',
                'read_time' => '5 min read',
                'meta_title' => 'New Nutrition Guidelines for Healthy Aging',
                'meta_description' => 'Decade study reveals dietary patterns for longevity'
            ],
            [
                'title' => 'Mental Health First Aid Required in All Workplaces',
                'content' => 'New legislation requires all workplaces to have certified mental health first aid responders, similar to physical first aid requirements. The law aims to address growing workplace mental health concerns.',
                'read_time' => '4 min read',
                'meta_title' => 'Mental Health First Aid Now Required at Work',
                'meta_description' => 'Landmark legislation addresses workplace mental health crisis'
            ],
            [
                'title' => 'Anti-Aging Drug Extends Lifespan in Human Trials',
                'content' => 'An experimental anti-aging drug has shown promising results in human trials, extending participants\' healthspan by 30% and reducing age-related diseases. The drug targets cellular senescence.',
                'read_time' => '5 min read',
                'meta_description' => 'Breakthrough drug shows lifespan extension in human trials',
                'meta_title' => 'Anti-Aging Drug Shows Promise in Human Trials'
            ],
            [
                'title' => 'Telehealth Usage Stabilizes at 50% of All Medical Visits',
                'content' => 'Two years after the pandemic, telehealth has stabilized at 50% of all medical consultations, transforming healthcare delivery and improving access for rural and homebound patients.',
                'read_time' => '4 min read',
                'meta_title' => 'Telehealth Accounts for Half of Medical Visits',
                'meta_description' => 'Virtual care becomes permanent fixture in healthcare system'
            ],
            [
                'title' => 'Sleep Study Reveals Optimal Hours for Heart Health',
                'content' => 'A massive study of 500,000 participants has identified the sleep duration associated with lowest heart disease risk: 7-8 hours per night. Both shorter and longer sleep increased risk.',
                'read_time' => '5 min read',
                'meta_title' => 'Study Reveals Optimal Sleep Hours for Heart Health',
                'meta_description' => 'Research identifies sleep duration linked to lowest disease risk'
            ],
            [
                'title' => 'Plant-Based Diet Reverses Diabetes in Clinical Trial',
                'content' => 'A clinical trial has found that a low-fat plant-based diet can reverse type 2 diabetes symptoms in 60% of participants within 12 weeks, offering a drug-free treatment option.',
                'read_time' => '6 min read',
                'meta_title' => 'Plant-Based Diet Reverses Diabetes in Trial',
                'meta_description' => 'Dietary intervention shows remarkable type 2 diabetes results'
            ],
        ];

        // Combine all posts with their respective categories
        $allPosts = [
            ['category_id' => 4, 'posts' => $businessPosts],
            ['category_id' => 5, 'posts' => $entertainmentPosts],
            ['category_id' => 6, 'posts' => $sportsPosts],
            ['category_id' => 7, 'posts' => $technologyPosts],
            ['category_id' => 9, 'posts' => $healthPosts],
        ];

        $postCounter = 0;

        // Create posts
        foreach ($allPosts as $categoryData) {
            foreach ($categoryData['posts'] as $index => $postData) {
                $postCounter++;
                $tags = [
                    ['trending', 'popular', 'breaking'],
                    ['featured', 'latest', 'update'],
                    ['exclusive', 'insight', 'analysis'],
                    ['hot', 'viral', 'must-read'],
                ];

                // Randomly assign author_id from 1 to 10 (matching your AuthorSeeder)
                $randomAuthorId = rand(1, 10);

                // Generate random published date within last 30 days
                $publishedAt = now()->subDays(rand(1, 30))->subHours(rand(1, 23));

                Post::create([
                    'user_id' => 1,
                    'author_id' => $randomAuthorId,
                    'category_id' => $categoryData['category_id'],
                    'title' => $postData['title'],
                    'slug' => Str::slug($postData['title']) . '-' . $postCounter,
                    'read_time' => $postData['read_time'],
                    'main_image' => null,
                    'meta_title' => $postData['meta_title'],
                    'meta_description' => $postData['meta_description'],
                    'meta_keywords' => 'news, trending, latest',
                    'content' => $this->generateDetailedContent($postData['content']),
                    'tags' => json_encode($tags[array_rand($tags)]),
                    'status' => 'published',
                    'published_at' => $publishedAt,
                    'created_at' => $publishedAt,
                    'updated_at' => $publishedAt,
                ]);
            }
        }

        $this->command->info('50 posts created successfully!');
    }

    /**
     * Generate detailed content with paragraphs
     */
    private function generateDetailedContent($mainContent)
    {
        $paragraphs = [
            "In a groundbreaking development that has captured global attention, experts are weighing in on this significant event.",
            "According to sources close to the matter, this marks a turning point in how we understand and approach.",
            "The implications of this development extend far beyond immediate concerns, potentially reshaping entire industries.",
            "Leading researchers and analysts have provided their insights, suggesting this could be just the beginning of a larger trend.",
            "Public reaction has been overwhelmingly positive, with social media platforms buzzing with discussions and debates.",
            "Industry veterans are calling this a 'paradigm shift' that will define the next decade of progress in this field.",
            "Critics, however, point to potential challenges and call for careful implementation of these new changes.",
            "What makes this particularly noteworthy is the speed at which changes are being adopted across different sectors.",
        ];

        // Shuffle and select 3-5 random paragraphs
        shuffle($paragraphs);
        $selectedParagraphs = array_slice($paragraphs, 0, rand(3, 5));

        // Add the main content and join with paragraphs
        $fullContent = "<p><strong>" . $mainContent . "</strong></p>\n\n";
        $fullContent .= "<p>" . implode("</p>\n\n<p>", $selectedParagraphs) . "</p>\n\n";

        // Add a conclusion
        $conclusions = [
            "<p>As we continue to monitor this developing story, one thing remains clear: the future is being written right now.</p>",
            "<p>Stay tuned for more updates as this story continues to unfold in the coming days and weeks.</p>",
            "<p>What are your thoughts on this development? Share your opinion in the comments below.</p>",
        ];

        $fullContent .= $conclusions[array_rand($conclusions)];

        return $fullContent;
    }
}