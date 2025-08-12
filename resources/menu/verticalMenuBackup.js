const menuItems = [
  {
    url: "/",
    name: "Dashboards",
    icon: "menu-icon tf-icons bx bx-home-circle",
    slug: "dashboard-analytics"
  },
  {
    url: "/user-management",
    name: "User Management",
    icon: "menu-icon tf-icons bx bx-group",
    slug: "user-management"
  },
  {
    url: "/company-management",
    name: "Company Management",
    icon: "menu-icon tf-icons bx bx-buildings",
    slug: "company-management"
  },
  {
    url: "/job-list",
    name: "Job List",
    icon: "menu-icon tf-icons bx bx-briefcase",
    slug: "job-list"
  },
  {
    url: "/candidate",
    name: "Candidate Management",
    icon: "menu-icon tf-icons bx bxs-user-account",
    slug: "candidate"
  },
  {
    url: "/activity-history",
    name: "Activity History",
    icon: "menu-icon tf-icons bx bx-history",
    slug: "activity-history"
  },
  {
    url: "/customer-support",
    name: "Customer Support",
    icon: "menu-icon tf-icons bx bx-envelope",
    slug: "customer-support"
  },
  {
    url: "/blogs",
    name: "Blogs",
    icon: "menu-icon tf-icons bx bx-book-content",
    slug: "blogs"
  },
  {
    url: "/blog-categories",
    name: "Blog Categories",
    icon: "menu-icon tf-icons bx bx-category",
    slug: "blog-categories"
  },
  {
    url: "/transaction-management",
    name: "Transaction Management",
    icon: "menu-icon tf-icons bx bx-dollar",
    slug: "transaction-management"
  },
  {
    url: "/",
    name: "Plan Management",
    icon: "menu-icon tf-icons bx bx-layer",
    slug: "plan",
    submenu: [
      {
        url: "/plan-subscriptions",
        name: "Subscriptions",
        slug: "plan-subscriptions"
      },
      {
        url: "/plan-alacarte",
        name: "Alacarte",
        slug: "plan-alacarte"
      }
    ]
  },
  {
    url: "/",
    name: "Master Data",
    icon: "menu-icon tf-icons bx bx-box",
    slug: "master",
    submenu: [
      {
        url: "/master-categories",
        name: "Categories",
        slug: "master-categories"
      },
      {
        url: "/master-job-levels",
        name: "Job Levels",
        slug: "master-job-levels"
      },
      {
        url: "/master-skills",
        name: "Skills",
        slug: "master-skills"
      },
      {
        url: "/master-tech-stacks",
        name: "Tech Stacks",
        slug: "master-tech-stacks"
      },
      {
        url: "/master-type-employments",
        name: "Employments",
        slug: "master-type-employments"
      },
      {
        url: "/master-industries",
        name: "Industries",
        slug: "master-industries"
      }
    ]
  },
  {
    url: "/settings",
    name: "Settings",
    icon: "menu-icon tf-icons bx bx-cog",
    slug: "settings"
  }
];

export default menuItems;