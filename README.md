# Artoria - Art Community Platform

> A modern, beautiful platform for artists to showcase their work, participate in challenges, and grow their community.

## Features

- **Artwork Showcase**: Upload and display your artwork with tags, categories, and descriptions
- **Challenges System**: Participate in or create art challenges with prizes and winners
- **User Roles**: Member, Curator, and Admin roles with specific permissions
- **Search & Filter**: Find artworks by categories, tags, or search terms
- **Responsive Design**: Works beautifully on all devices
- **Modern UI**: Glassmorphism design with dark theme and gradient accents
- **User Profiles**: Personal profiles with portfolio links and social media
- **Like & Favorite System**: Engage with artworks from the community
- **Admin Dashboard**: Manage users, artworks, and challenges

## Tech Stack

- **Backend**: Laravel 12
- **Frontend**: Blade Templates + Tailwind CSS
- **Database**: MySQL
- **Styling**: Tailwind CSS + Custom Components

##  Quick Start

### Prerequisites

- PHP 8.2+
- Composer
- Node.js & npm
- MySQL

### Installation

1. Clone the repository:
```bash
git clone <your-repo-url>
cd artoria
```
2. Install PHP dependencies
3. Install Node.js Depedency
4. Copy .env.example to .env and configure your database:
5. Configure database in .env:

### Project Structure
app/
├── Http/
│   ├── Controllers/
│   │   ├── ArtworkController.php
│   │   ├── ChallengeController.php
│   │   └── Curator/
│   │       └── ChallengeManagementController.php
├── Models/
│   ├── User.php
│   ├── Artwork.php
│   ├── Challenge.php
│   └── ChallengeEntry.php
resources/
├── views/
│   ├── layouts/
│   ├── artworks/
│   ├── challenges/
│   └── curator/
└── css/
    └── app.css (Tailwind + Custom)

## 🎯 Key Features

### Artwork Management
- **Upload System**: Users can upload their artworks with title, description, categories, and tags
- **Responsive Display**: Beautiful masonry grid layout for artwork showcase
- **Like & Favorite**: Engage with artworks through like and favorite system
- **Comment System**: Users can comment on artworks to provide feedback
- **Category & Tag Filtering**: Organize and discover artworks by categories and tags

### Challenge System
- **Challenge Creation**: Curators can create art challenges with rules, prizes, and deadlines
- **Artwork Submission**: Users can submit their artworks to challenges
- **Winner Selection**: Curators can select winners from submitted entries
- **Challenge Timeline**: Track challenges by status (upcoming, active, ended)
- **Prize Management**: Define prizes for challenge winners

### User System
- **Role Management**: Three distinct roles (Member, Curator, Admin) with specific permissions
- **Profile Management**: Users can manage their display name, bio, and social links
- **Portfolio Integration**: Members can apply to become curators by submitting portfolio
- **Status Tracking**: User status management (active, pending, banned, suspended)

### Search & Discovery
- **Advanced Search**: Find artworks by title, description, or tags
- **Category Filtering**: Filter artworks by specific categories
- **Sorting Options**: Sort by latest, popular, or most viewed
- **Trending Tags**: Discover popular themes in the community

### Admin Panel
- **User Management**: View and manage all users with different roles
- **Artwork Moderation**: Review and moderate uploaded artworks
- **Challenge Oversight**: Monitor all challenges and submissions
- **System Analytics**: Track user growth and platform statistics

### Responsive Design
- **Mobile First**: Fully responsive layout for all device sizes
- **Modern UI**: Glassmorphism design with dark theme and gradient accents
- **Smooth Animations**: Interactive hover effects and transitions
- **Accessibility**: Proper ARIA labels and keyboard navigation support

### Security Features
- **Authentication**: Secure user registration and login system
- **Authorization**: Role-based access control for different features
- **Input Validation**: Comprehensive validation for all user inputs
- **File Security**: Safe file upload with type and size restrictions

