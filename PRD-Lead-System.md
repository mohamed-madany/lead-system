# Product Requirements Document (PRD)
## Lead Management System

**Document Version:** 1.0  
**Last Updated:** January 17, 2026  
**Status:** Production Ready  
**Author:** Development Team  

---

## 1. Executive Summary

This document outlines comprehensive technical requirements for building a **Lead Management System** using Laravel 12, Filament 5, and Livewire 4. The system provides dual interfaces: a customer-facing lead capture form and an internal admin dashboard for lead management. The solution must be production-ready, scalable, and maintainable.

**Core Objectives:**
- Capture leads through public-facing Livewire forms
- Manage leads through admin dashboard with Filament
- Integrate with external services (N8n workflow automation)
- Implement intelligent lead scoring and qualification
- Provide real-time analytics and reporting

---

## 2. Technical Stack

### Backend
- **Framework:** Laravel 12.x
- **PHP Version:** 8.4+
- **Database:** MySQL 8.0+ or PostgreSQL 13+
- **Task Scheduling:** Laravel Scheduler
- **Queue System:** Laravel Queue (Redis for production, database for development)
- **Caching:** Redis (production) / File-based (development)
- **API:** REST API (HTTP, JSON)

### Frontend
- **UI Framework:** Filament 5.x (Admin Panel)
- **Reactive Component:** Livewire 4.x (Customer Forms)
- **Styling:** Tailwind CSS 3.x
- **JavaScript:** Alpine.js v3.x (included with Livewire)
- **Form Validation:** Livewire real-time validation + Server-side validation

### DevOps & Infrastructure
- **Version Control:** Git
- **CI/CD:** GitHub Actions (or equivalent)
- **Containerization:** Docker & Docker Compose
- **Server:** Nginx / Apache
- **Monitoring:** Laravel Telescope (development)
- **Logging:** Laravel Log (file/stack driver)

### Dependencies
```json
{
  "laravel/framework": "^12.0",
  "filament/filament": "^4.0",
  "livewire/livewire": "^4.0",
  "laravel/tinker": "^2.0",
  "spatie/laravel-permission": "^6.0"
}
```

---

## 3. Architecture Overview

### System Architecture (Layered)

```
┌─────────────────────────────────────────────────────────┐
│  Presentation Layer (UI)                                │
│  ├─ Filament Admin Panel (Backend)                       │
│  ├─ Livewire Components (Frontend)                       │
│  └─ Blade Templates (Web Pages)                          │
└──────────────────┬──────────────────────────────────────┘
                   │ HTTP Requests
┌──────────────────▼──────────────────────────────────────┐
│  Application Layer (Business Logic)                      │
│  ├─ Services (LeadService, etc.)                         │
│  ├─ Actions (CreateLead, UpdateLead, etc.)               │
│  ├─ Jobs (SendLeadToN8n, SendNotification)               │
│  ├─ DTOs (LeadData, etc.)                                │
│  └─ Events (LeadCreated, LeadQualified)                  │
└──────────────────┬──────────────────────────────────────┘
                   │
┌──────────────────▼──────────────────────────────────────┐
│  Domain Layer (Core Business)                            │
│  ├─ Models (Lead, User, Activity)                        │
│  ├─ Enums (LeadStatus, ActivityType)                     │
│  ├─ Casts (Custom attribute casting)                     │
│  ├─ Rules (Custom validation rules)                      │
│  └─ Events (Domain events)                               │
└──────────────────┬──────────────────────────────────────┘
                   │
┌──────────────────▼──────────────────────────────────────┐
│  Infrastructure Layer (Data & External Services)         │
│  ├─ Repositories (LeadRepository, UserRepository)        │
│  ├─ Cache Managers (LeadCache, StatCache)                │
│  ├─ External Clients (N8nClient, MailClient)             │
│  └─ Migrations (Database schema)                         │
└──────────────────┬──────────────────────────────────────┘
                   │
┌──────────────────▼──────────────────────────────────────┐
│  Data Access Layer (Database)                            │
│  ├─ MySQL/PostgreSQL                                     │
│  ├─ Redis Cache                                          │
│  └─ Message Queue (Redis/Database)                       │
└─────────────────────────────────────────────────────────┘
```

### Folder Structure

```
lead-management-system/
├── app/
│   ├── Domain/
│   │   ├── Lead/
│   │   │   ├── Models/
│   │   │   │   ├── Lead.php
│   │   │   │   ├── LeadActivity.php
│   │   │   │   └── LeadInteraction.php
│   │   │   ├── Enums/
│   │   │   │   ├── LeadStatus.php
│   │   │   │   ├── ActivityType.php
│   │   │   │   └── LeadSource.php
│   │   │   ├── Events/
│   │   │   │   ├── LeadCreated.php
│   │   │   │   ├── LeadQualified.php
│   │   │   │   ├── LeadStatusChanged.php
│   │   │   │   └── LeadScored.php
│   │   │   ├── Rules/
│   │   │   │   ├── ValidPhoneNumber.php
│   │   │   │   ├── ValidEmail.php
│   │   │   │   └── UniqueLeadPerEmail.php
│   │   │   └── Casts/
│   │   │       └── LeadStatusCast.php
│   │   └── User/
│   │       ├── Models/
│   │       │   └── User.php
│   │       └── Enums/
│   │           └── UserRole.php
│   │
│   ├── Application/
│   │   ├── Lead/
│   │   │   ├── Services/
│   │   │   │   ├── LeadService.php
│   │   │   │   ├── LeadScoringService.php
│   │   │   │   └── LeadQualificationService.php
│   │   │   ├── Actions/
│   │   │   │   ├── CreateLeadAction.php
│   │   │   │   ├── UpdateLeadAction.php
│   │   │   │   ├── QualifyLeadAction.php
│   │   │   │   ├── DeleteLeadAction.php
│   │   │   │   └── BulkUpdateLeadsAction.php
│   │   │   ├── DTOs/
│   │   │   │   ├── LeadData.php
│   │   │   │   ├── LeadFilterData.php
│   │   │   │   └── LeadScoreData.php
│   │   │   ├── Jobs/
│   │   │   │   ├── SendLeadToN8n.php
│   │   │   │   ├── SendLeadNotification.php
│   │   │   │   ├── ProcessLeadQualification.php
│   │   │   │   └── GenerateDailyReport.php
│   │   │   └── Listeners/
│   │   │       ├── LogLeadCreated.php
│   │   │       ├── NotifyOnLeadQualification.php
│   │   │       └── UpdateLeadStats.php
│   │   └── User/
│   │       └── Services/
│   │           └── UserService.php
│   │
│   ├── Infrastructure/
│   │   ├── Repositories/
│   │   │   ├── Contracts/
│   │   │   │   ├── LeadRepositoryInterface.php
│   │   │   │   └── UserRepositoryInterface.php
│   │   │   ├── EloquentLeadRepository.php
│   │   │   └── EloquentUserRepository.php
│   │   ├── Cache/
│   │   │   ├── LeadCache.php
│   │   │   ├── StatisticsCache.php
│   │   │   └── CacheKeys.php
│   │   ├── External/
│   │   │   ├── N8nClient.php
│   │   │   ├── MailClient.php
│   │   │   └── WebhookClient.php
│   │   └── Persistence/
│   │       └── Migrations/
│   │
│   ├── Interfaces/
│   │   ├── Web/
│   │   │   └── Controllers/
│   │   │       ├── HomeController.php
│   │   │       ├── LeadController.php
│   │   │       └── ThankYouController.php
│   │   ├── Livewire/
│   │   │   ├── Forms/
│   │   │   │   └── LeadCaptureForm.php
│   │   │   ├── Modals/
│   │   │   │   └── LeadDetailModal.php
│   │   │   └── Tables/
│   │   │       └── LeadsTable.php
│   │   ├── Filament/
│   │   │   ├── Resources/
│   │   │   │   ├── LeadResource.php
│   │   │   │   ├── UserResource.php
│   │   │   │   └── ActivityLogResource.php
│   │   │   ├── Pages/
│   │   │   │   ├── Dashboard.php
│   │   │   │   ├── LeadAnalytics.php
│   │   │   │   └── ConversionReport.php
│   │   │   └── Widgets/
│   │   │       ├── LeadCountWidget.php
│   │   │       ├── ConversionRateWidget.php
│   │   │       ├── RevenueWidget.php
│   │   │       └── LeadSourceChart.php
│   │   └── Http/
│   │       └── Middleware/
│   │           └── TrackLeadActivity.php
│   │
│   ├── Providers/
│   │   ├── AppServiceProvider.php
│   │   ├── RepositoryServiceProvider.php
│   │   └── EventServiceProvider.php
│   │
│   ├── Exceptions/
│   │   ├── LeadNotFoundException.php
│   │   ├── InvalidLeadStatusException.php
│   │   └── N8nWebhookException.php
│   │
│   └── Console/
│       └── Commands/
│           ├── SendDailyReports.php
│           ├── ProcessPendingLeads.php
│           └── CleanupOldLeads.php
│
├── database/
│   ├── migrations/
│   │   ├── 2026_01_17_000001_create_users_table.php
│   │   ├── 2026_01_17_000002_create_leads_table.php
│   │   ├── 2026_01_17_000003_create_lead_activities_table.php
│   │   ├── 2026_01_17_000004_create_lead_interactions_table.php
│   │   ├── 2026_01_17_000005_create_jobs_table.php
│   │   └── 2026_01_17_000006_create_queue_batches_table.php
│   ├── seeders/
│   │   ├── DatabaseSeeder.php
│   │   ├── UserSeeder.php
│   │   └── LeadSeeder.php
│   └── factories/
│       ├── UserFactory.php
│       └── LeadFactory.php
│
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   ├── footer.blade.php
│   │   │   └── navbar.blade.php
│   │   ├── pages/
│   │   │   ├── home.blade.php
│   │   │   ├── contact.blade.php
│   │   │   ├── thank-you.blade.php
│   │   │   └── error.blade.php
│   │   ├── livewire/
│   │   │   ├── lead-form.blade.php
│   │   │   └── success-message.blade.php
│   │   └── emails/
│   │       ├── lead-confirmation.blade.php
│   │       └── admin-notification.blade.php
│   ├── css/
│   │   ├── app.css
│   │   └── admin.css
│   └── js/
│       ├── app.js
│       └── admin.js
│
├── routes/
│   ├── web.php
│   ├── api.php
│   └── admin.php
│
├── tests/
│   ├── Feature/
│   │   ├── LeadCreationTest.php
│   │   ├── LeadScoringTest.php
│   │   ├── LeadFiltersTest.php
│   │   └── N8nIntegrationTest.php
│   ├── Unit/
│   │   ├── LeadServiceTest.php
│   │   ├── LeadRepositoryTest.php
│   │   └── LeadScoringServiceTest.php
│   └── Pest.php
│
├── config/
│   ├── app.php
│   ├── database.php
│   ├── queue.php
│   ├── cache.php
│   ├── services.php
│   └── lead-system.php (custom config)
│
├── .env.example
├── .gitignore
├── docker-compose.yml
├── Dockerfile
└── README.md
```

---

## 4. Database Schema

### 4.1 Users Table

```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NULL,
    role ENUM('admin', 'manager', 'user') DEFAULT 'user',
    is_active BOOLEAN DEFAULT TRUE,
    last_login_at TIMESTAMP NULL,
    avatar_url VARCHAR(500) NULL,
    settings JSON NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    
    INDEX idx_email (email),
    INDEX idx_role (role),
    INDEX idx_is_active (is_active),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 4.2 Leads Table

```sql
CREATE TABLE leads (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    
    -- Contact Information
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    company_name VARCHAR(255) NULL,
    job_title VARCHAR(255) NULL,
    
    -- Lead Management
    status ENUM('new', 'contacted', 'qualified', 'won', 'lost', 'archived') DEFAULT 'new',
    source ENUM('form', 'referral', 'campaign', 'manual', 'import', 'api') DEFAULT 'form',
    lead_type ENUM('cold', 'warm', 'hot', 'customer') DEFAULT 'cold',
    
    -- Scoring & Classification
    score INT DEFAULT 0 COMMENT 'Lead score 0-100',
    score_breakdown JSON NULL COMMENT 'Detailed score breakdown',
    quality_rating ENUM('poor', 'fair', 'good', 'excellent') DEFAULT 'fair',
    
    -- Notes & Information
    notes TEXT NULL,
    internal_comments TEXT NULL,
    metadata JSON NULL COMMENT 'Custom fields and data',
    
    -- Assignment & Ownership
    assigned_to BIGINT UNSIGNED NULL,
    assigned_at TIMESTAMP NULL,
    
    -- Dates
    last_contacted_at TIMESTAMP NULL,
    qualified_at TIMESTAMP NULL,
    won_at TIMESTAMP NULL,
    
    -- Additional
    estimated_value DECIMAL(15, 2) NULL,
    probability_percentage INT DEFAULT 0,
    
    -- Soft Delete
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    
    -- Indexes for Performance
    INDEX idx_email (email),
    INDEX idx_phone (phone),
    INDEX idx_status (status),
    INDEX idx_source (source),
    INDEX idx_score (score),
    INDEX idx_assigned_to (assigned_to),
    INDEX idx_created_at (created_at),
    INDEX idx_status_created (status, created_at),
    INDEX idx_email_status (email, status),
    
    -- Foreign Keys
    FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 4.3 Lead Activities Table

```sql
CREATE TABLE lead_activities (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    
    lead_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NULL,
    
    activity_type ENUM('call', 'email', 'meeting', 'note', 'status_change', 'score_update', 'assignment', 'qualification') NOT NULL,
    description TEXT NOT NULL,
    metadata JSON NULL,
    
    -- Contact attempt tracking
    contact_method ENUM('phone', 'email', 'sms', 'in_person', 'video_call') NULL,
    duration_minutes INT NULL,
    result ENUM('successful', 'failed', 'no_answer', 'voicemail', 'pending') NULL,
    
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    INDEX idx_lead_id (lead_id),
    INDEX idx_user_id (user_id),
    INDEX idx_activity_type (activity_type),
    INDEX idx_created_at (created_at),
    
    FOREIGN KEY (lead_id) REFERENCES leads(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 4.4 Lead Interactions Table

```sql
CREATE TABLE lead_interactions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    
    lead_id BIGINT UNSIGNED NOT NULL,
    interaction_type ENUM('website_visit', 'email_open', 'link_click', 'form_submission', 'download', 'chat') NOT NULL,
    
    interaction_data JSON NULL,
    ip_address VARCHAR(45) NULL,
    user_agent VARCHAR(500) NULL,
    
    created_at TIMESTAMP NULL,
    
    INDEX idx_lead_id (lead_id),
    INDEX idx_interaction_type (interaction_type),
    INDEX idx_created_at (created_at),
    
    FOREIGN KEY (lead_id) REFERENCES leads(id) ON DELETE CASCADE
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 4.5 Jobs Table (Laravel Queue)

```sql
CREATE TABLE jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload LONGTEXT NOT NULL,
    attempts TINYINT UNSIGNED NOT NULL DEFAULT 0,
    reserved_at INT UNSIGNED NULL,
    available_at INT UNSIGNED NOT NULL,
    created_at INT UNSIGNED NOT NULL,
    
    INDEX idx_queue (queue),
    INDEX idx_available_at_reserved_at (available_at, reserved_at)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 4.6 Failed Jobs Table

```sql
CREATE TABLE failed_jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    connection VARCHAR(255) NOT NULL,
    queue VARCHAR(255) NOT NULL,
    payload LONGTEXT NOT NULL,
    exception LONGTEXT NOT NULL,
    failed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_connection_queue (connection, queue)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 5. Technical Requirements (Complete)

### 5.1 Frontend (Public-Facing Customer Interface)

#### 5.1.1 Arabic Landing Page 
**Features:**
- Hero section with headline and CTA
- Trust indicators (badges, testimonials)
- Feature highlights
- Call-to-action button to contact form
- Responsive design (mobile-first)
- Fast loading time (< 2s)
- SEO optimized

**Technical Requirements:**
- Built with Blade templates
- Tailwind CSS styling
- SEO meta tags
- Structured data (Schema.org)
- Open Graph tags for sharing

#### 5.1.2 Contact/Lead Capture Form (Livewire Component)

**Form Fields:**
```
Required:
- Full Name (3-255 characters)
- Email Address (valid email format)
- Phone Number (10-20 digits, international format support)

Optional:
- Company Name (max 255 characters)
- Job Title (max 255 characters)
- Message/Notes (max 2000 characters)
- Lead Source (dropdown: Form, Referral, Campaign, Other)
- Budget Range (if applicable)
```

**Validation Rules:**
- Real-time validation with Livewire
- Server-side validation (double validation)
- Email uniqueness check (warn if duplicate)
- Phone format validation
- Rate limiting (1 submission per IP every 5 minutes)

**Form Features:**
- Loading state during submission
- Error message display with field highlighting
- Success message with lead tracking ID
- CSRF token protection
- Honeypot field (spam protection)
- Recaptcha v3 integration (optional)

**User Experience:**
- Auto-focus on first field
- Tab key navigation support
- Phone number formatting (auto-format as user types)
- Password manager compatibility
- Keyboard shortcuts support

#### 5.1.3 Thank You Page
**Features:**
- Success message with personalized greeting
- Next steps information
- Lead tracking ID for reference
- Expected follow-up timeframe
- CTA to return to homepage
- Social sharing options
- Email confirmation link

#### 5.1.4 Public Navigation & Footer
**Navigation:**
- Logo linking to home
- Primary navigation menu
- CTA button
- Mobile hamburger menu

**Footer:**
- Company information
- Quick links
- Social media links
- Privacy policy link
- Terms of service link
- Contact information

### 5.2 Backend Admin Dashboard (Filament Panel)

#### 5.2.1 Authentication System
**Features:**
- Login page with email/password
- "Remember me" functionality
- Password reset via email
- Two-factor authentication (optional but recommended)
- Session management
- Admin-only access control
- Activity logging for admin actions

**Security:**
- HTTPS enforced
- Rate limiting on login attempts (5 attempts per 15 minutes)
- Session timeout (30 minutes inactivity)
- IP whitelisting (optional)

#### 5.2.2 Dashboard/Analytics Page

**Key Metrics Widgets:**
1. **Total Leads** - Count of all leads
2. **New Leads** - Count of leads from last 24 hours
3. **Qualified Leads** - Count of leads with qualified status
4. **Conversion Rate** - Won leads / Total leads * 100
5. **Average Lead Score** - Mean score across all leads
6. **Lead Sources Distribution** - Pie chart of sources
7. **Status Distribution** - Bar chart of lead statuses
8. **Win/Loss Ratio** - Comparison of won vs lost leads
9. **Revenue Potential** - Sum of estimated values for qualified leads
10. **Activity This Week** - Number of activities logged

**Chart Types:**
- Line chart for leads over time (30-day trend)
- Pie chart for source distribution
- Bar chart for status breakdown
- Gauge chart for conversion rate
- Area chart for cumulative leads

**Features:**
- Real-time data updates
- Date range picker (today, 7 days, 30 days, 90 days, custom)
- Export data as PDF/CSV
- Email report scheduling
- Drill-down capabilities (click metrics to filter leads)
- Comparison with previous period
- Cacheable for performance

#### 5.2.3 Lead Management - CRUD Operations

**List View (Leads Table):**
- Columns:
  - Lead name (clickable to view details)
  - Email address (with copy button)
  - Phone number (with call button if supported)
  - Company name
  - Status badge (color-coded)
  - Lead score with progress bar
  - Assigned to (user name or "Unassigned")
  - Last contacted date
  - Action buttons
  
**Sorting & Filtering:**
- Sort by: Name, Email, Score, Created Date, Last Contact Date
- Filter by:
  - Status (multi-select dropdown)
  - Source (multi-select dropdown)
  - Score range (slider: 0-100)
  - Lead type (cold, warm, hot, customer)
  - Assigned user
  - Date range (created, last contacted, qualified)
  - Search by name, email, phone, company
  
**Pagination:**
- 10, 25, 50 items per page (configurable)
- Jump to page input
- First/Last page buttons
- Previous/Next buttons

**Inline Actions:**
- View details
- Edit lead
- Change status (dropdown with status options)
- Assign to user (dropdown with user list)
- Mark as won/lost
- Delete with confirmation
- Add activity/note
- Send email

**Bulk Actions:**
- Select multiple leads (checkbox)
- Delete multiple leads
- Change status for multiple
- Assign to user for multiple
- Send email to multiple
- Export selected as CSV

**Create Lead:**
- Form with all required fields
- Optional metadata fields
- Address field with geolocation
- Attachment upload (documents, images)
- Validation with real-time feedback
- Pre-fill source field
- Template options (pre-filled common data)

**Edit Lead:**
- All fields editable
- Change history visible
- Activity log in sidebar
- Email history
- Previous interactions
- Status change confirmation
- Auto-save draft feature

**View Details (Modal/Page):**
- Complete lead information
- Activity timeline
- Contact history
- Interactions log
- Notes section
- Attachments
- Related documents
- Previous communications
- Lead score breakdown
- Next steps recommendation
- Similar leads suggestions

#### 5.2.4 Lead Scoring System

**Scoring Criteria:**
```
Base Score: 0-100 points

Qualification Points:
- Email provided: +20 points
- Phone provided: +25 points
- Corporate email (@company.com): +15 points
- Company name provided: +10 points
- Job title provided: +10 points
- Full message/notes: +10 points

Contact Quality:
- Response to email: +5 points
- Website visit after lead creation: +5 points
- Opening email: +3 points
- Clicking link in email: +5 points

Timing Bonus:
- Lead created during business hours: +3 points
- Multiple interactions: +5 points
- Quick response to communication: +5 points

Penalties:
- Bounced email: -10 points
- Wrong phone number: -5 points
- Spam keywords detected: -15 points
- Unsubscribe request: -20 points

Automatic Qualification:
- If score >= 70: Automatically mark as "Qualified"
- If score >= 90: Automatically mark as "Hot Lead"
- If score < 30: Mark as "Cold Lead" for follow-up
```

**Score Display:**
- Progress bar with color indicators (red < 30, yellow 30-70, green > 70)
- Detailed breakdown showing which factors contributed
- Historical score tracking
- Score prediction tool

#### 5.2.5 Lead Status Management

**Status Workflow:**
```
new → contacted → qualified → won (end)
                          ↓
                         lost (end)
                          ↓
                       archived (end)
```

**Status Descriptions:**
- **New**: Lead just captured, not yet contacted
- **Contacted**: Outreach made, waiting for response
- **Qualified**: Lead meets criteria for sales
- **Won**: Deal closed successfully
- **Lost**: Lead rejected or disqualified
- **Archived**: Historical leads not in active pipeline

**Status Change Automation:**
- Automatic status change triggers
- Confirmation before status change
- Activity logging with timestamp
- Notification to assigned user
- Email to lead on significant status changes (optional)

#### 5.2.6 User Management

**User List View:**
- Name, Email, Role, Status, Last Login, Actions

**User Roles & Permissions:**
```
Admin:
- Full system access
- User management
- System settings
- Report access
- Team management

Manager:
- View team leads
- Assign leads
- Generate reports
- User activity monitoring
- Team performance metrics

Sales Rep:
- View assigned leads
- Update own leads
- Log activities
- Limited reporting
```

**User Creation/Editing:**
- Name, Email, Phone, Role, Status
- Password generation or custom set
- Assign to team (if applicable)
- Permissions configuration
- Avatar upload
- Notification preferences

#### 5.2.7 Activity Logging

**Activity Types to Log:**
- Lead created (who created, from where)
- Status changed (from/to)
- Score updated (old/new score)
- Assigned to user (from/to)
- Email sent (subject, timestamp)
- Note added
- File attached
- Contact made (call, email, SMS)
- User login/logout
- Data exported
- Bulk operations

**Activity Log Features:**
- Timestamp for every action
- User who performed action
- Before/after comparison
- Searchable by action type
- Filter by date range
- Export as PDF/CSV
- Undo functionality (for safe operations)

### 5.3 Backend Integrations

#### 5.3.1 N8n Webhook Integration

**Trigger:** Lead creation event

**Webhook Payload Structure:**
```json
{
  "event": "lead.created",
  "timestamp": "2026-01-17T10:30:00Z",
  "lead": {
    "id": 12345,
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "+1234567890",
    "company_name": "TechCorp",
    "job_title": "Manager",
    "status": "new",
    "score": 65,
    "source": "form",
    "notes": "Interested in premium plan",
    "created_at": "2026-01-17T10:30:00Z"
  },
  "webhook_signature": "sha256_hash_for_verification"
}
```

**Retry Strategy:**
- Retry up to 3 times
- Exponential backoff: 60s, 300s, 900s
- Timeout: 30 seconds per attempt
- Log all attempts and failures
- Alert on repeated failures

**Webhook Verification:**
- HMAC-SHA256 signature verification
- Timestamp validation (within 5 minutes)
- Webhook URL from environment config
- Secret key from environment config

**N8n Actions Examples:**
- Create CRM contact
- Send Slack notification
- Add to email sequence
- Create calendar event
- Generate PDF proposal
- Send SMS notification
- Create Airtable record
- Update spreadsheet
- Trigger custom workflow

#### 5.3.2 Email Integration

**Email Service:**
- SMTP configuration (SendGrid, Mailgun, AWS SES, custom)
- Email templates using Blade
- Queue-based sending (async)

**Email Templates:**
1. **Lead Confirmation** - Sent to lead after form submission
   - Thank you message
   - Next steps
   - Lead ID
   - Company information
   
2. **Admin Notification** - Sent to assigned user
   - Lead details summary
   - Qualification score
   - Direct link to manage lead
   - Quick action buttons
   
3. **Status Change Notification** - When lead status changes
   - New status
   - Assigned user (if changed)
   - Summary of lead
   
4. **Daily Summary** - Sent to managers
   - New leads count
   - Qualified leads count
   - Lost leads summary
   - Top performing sources
   
5. **Weekly Report** - Comprehensive metrics
   - Lead generation trend
   - Conversion funnel
   - Top performers
   - Sources performance

**Email Features:**
- Rich HTML templates
- Responsive design
- Unsubscribe link
- Plain text fallback
- Tracking pixels (optional)
- Link tracking (optional)
- Delivery status tracking

#### 5.3.3 Cache Strategy

**What to Cache:**
- Dashboard statistics (TTL: 1 hour)
- Lead status distribution (TTL: 30 minutes)
- User list (TTL: 24 hours)
- Configuration (TTL: 24 hours)
- Leaderboards (TTL: 1 hour)
- Search indexes (TTL: 2 hours)

**Cache Invalidation:**
- Manual: Admin can clear cache
- Automatic: On data change
- Scheduled: Every hour for stats
- Event-based: On lead creation/update

**Cache Implementation:**
```
Cache Key Naming:
- lead:list:{page}:{filter_hash}
- lead:stats:{period}
- lead:score_distribution
- user:leaderboard:{metric}
- dashboard:widgets:{user_id}
```

---

## 6. Detailed Technical Specifications

### 6.1 Domain Layer Implementation

#### Lead Model
```php
namespace App\Domain\Lead\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domain\Lead\Enums\LeadStatus;

class Lead extends Model
{
    use SoftDeletes, HasFactory;
    
    protected $fillable = [
        'name', 'email', 'phone', 'company_name', 'job_title',
        'status', 'source', 'lead_type', 'score', 'quality_rating',
        'notes', 'internal_comments', 'assigned_to', 'assigned_at',
        'last_contacted_at', 'qualified_at', 'won_at',
        'estimated_value', 'probability_percentage', 'metadata'
    ];
    
    protected $casts = [
        'status' => LeadStatus::class,
        'score' => 'integer',
        'probability_percentage' => 'integer',
        'estimated_value' => 'decimal:2',
        'assigned_at' => 'datetime',
        'last_contacted_at' => 'datetime',
        'qualified_at' => 'datetime',
        'won_at' => 'datetime',
        'metadata' => 'array',
        'score_breakdown' => 'array',
    ];
    
    protected $dispatchesEvents = [
        'created' => \App\Domain\Lead\Events\LeadCreated::class,
        'updated' => \App\Domain\Lead\Events\LeadUpdated::class,
    ];
    
    // Business Methods
    public function qualify(): void
    {
        $this->update(['status' => LeadStatus::QUALIFIED, 'qualified_at' => now()]);
        event(new \App\Domain\Lead\Events\LeadQualified($this));
    }
    
    public function markAsWon(float $value = null): void
    {
        $this->update([
            'status' => LeadStatus::WON,
            'won_at' => now(),
            'estimated_value' => $value ?? $this->estimated_value,
        ]);
        event(new \App\Domain\Lead\Events\LeadWon($this));
    }
    
    public function markAsLost(string $reason = null): void
    {
        $this->update([
            'status' => LeadStatus::LOST,
            'metadata' => array_merge($this->metadata ?? [], ['lost_reason' => $reason])
        ]);
        event(new \App\Domain\Lead\Events\LeadLost($this));
    }
    
    public function recordActivity(string $type, string $description, array $metadata = []): LeadActivity
    {
        return $this->activities()->create([
            'activity_type' => $type,
            'description' => $description,
            'metadata' => $metadata,
            'user_id' => auth()->id(),
        ]);
    }
    
    // Relationships
    public function assignedUser()
    {
        return $this->belongsTo(\App\Models\User::class, 'assigned_to');
    }
    
    public function activities()
    {
        return $this->hasMany(LeadActivity::class)->orderByDesc('created_at');
    }
    
    public function interactions()
    {
        return $this->hasMany(LeadInteraction::class);
    }
    
    // Query Scopes
    public function scopeQualified($query)
    {
        return $query->where('status', LeadStatus::QUALIFIED);
    }
    
    public function scopeBySource($query, $source)
    {
        return $query->where('source', $source);
    }
    
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
    
    public function scopeWithHighScore($query, $minScore = 70)
    {
        return $query->where('score', '>=', $minScore);
    }
    
    public function scopeAssignedTo($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }
    
    public function scopeCreatedBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }
}
```

#### LeadStatus Enum
```php
namespace App\Domain\Lead\Enums;

enum LeadStatus: string
{
    case NEW = 'new';
    case CONTACTED = 'contacted';
    case QUALIFIED = 'qualified';
    case WON = 'won';
    case LOST = 'lost';
    case ARCHIVED = 'archived';
    
    public function label(): string
    {
        return match($this) {
            self::NEW => 'New Lead',
            self::CONTACTED => 'Contacted',
            self::QUALIFIED => 'Qualified',
            self::WON => 'Won Deal',
            self::LOST => 'Lost Opportunity',
            self::ARCHIVED => 'Archived',
        };
    }
    
    public function color(): string
    {
        return match($this) {
            self::WON => 'success',
            self::QUALIFIED => 'info',
            self::CONTACTED => 'warning',
            self::LOST => 'danger',
            self::ARCHIVED => 'secondary',
            self::NEW => 'primary',
        };
    }
    
    public function isTerminal(): bool
    {
        return in_array($this, [self::WON, self::LOST, self::ARCHIVED]);
    }
}
```

### 6.2 Application Layer Implementation

#### LeadService
```php
namespace App\Application\Lead\Services;

use App\Domain\Lead\Models\Lead;
use App\Infrastructure\Repositories\Contracts\LeadRepositoryInterface;
use App\Application\Lead\Services\LeadScoringService;
use App\Application\Lead\DTOs\LeadData;
use App\Application\Lead\Jobs\SendLeadToN8n;
use Illuminate\Support\Facades\DB;

class LeadService
{
    public function __construct(
        private LeadRepositoryInterface $leadRepository,
        private LeadScoringService $scoringService,
    ) {}
    
    public function createLead(LeadData $data): Lead
    {
        return DB::transaction(function () use ($data) {
            $lead = $this->leadRepository->create($data->toArray());
            
            $score = $this->scoringService->calculateScore($lead);
            $lead->update(['score' => $score]);
            
            if ($score >= 70) {
                $lead->qualify();
            }
            
            SendLeadToN8n::dispatch($lead);
            
            return $lead->fresh();
        });
    }
    
    public function updateLead(Lead $lead, LeadData $data): Lead
    {
        return DB::transaction(function () use ($lead, $data) {
            $updated = $this->leadRepository->update($lead, $data->toArray());
            
            $score = $this->scoringService->calculateScore($updated);
            if ($score !== $updated->score) {
                $updated->update(['score' => $score]);
            }
            
            return $updated->fresh();
        });
    }
    
    public function deleteLead(Lead $lead): bool
    {
        return $this->leadRepository->delete($lead);
    }
    
    public function changeStatus(Lead $lead, string $newStatus): Lead
    {
        $lead->update(['status' => $newStatus]);
        return $lead->fresh();
    }
    
    public function assignToUser(Lead $lead, int $userId): Lead
    {
        $lead->update([
            'assigned_to' => $userId,
            'assigned_at' => now(),
        ]);
        return $lead->fresh();
    }
}
```

#### LeadScoringService
```php
namespace App\Application\Lead\Services;

use App\Domain\Lead\Models\Lead;
use App\Application\Lead\DTOs\LeadScoreData;

class LeadScoringService
{
    public function calculateScore(Lead $lead): int
    {
        $breakdown = [];
        $totalScore = 0;
        
        // Contact Information (Max: 50 points)
        $totalScore += $breakdown['email'] = $lead->email ? 20 : 0;
        $totalScore += $breakdown['phone'] = $lead->phone ? 25 : 0;
        $totalScore += $breakdown['company'] = $lead->company_name ? 5 : 0;
        
        // Email Quality (Max: 15 points)
        if ($lead->email) {
            $totalScore += $breakdown['corporate_email'] = $this->isCorporateEmail($lead->email) ? 10 : 0;
            $totalScore += $breakdown['email_quality'] = $this->checkEmailQuality($lead->email) ? 5 : 0;
        }
        
        // Content Quality (Max: 15 points)
        $totalScore += $breakdown['job_title'] = $lead->job_title ? 5 : 0;
        $totalScore += $breakdown['notes'] = $lead->notes && strlen($lead->notes) > 50 ? 10 : 0;
        
        // Source Quality (Max: 10 points)
        $totalScore += $breakdown['source'] = $this->getSourceScore($lead->source);
        
        // Timing (Max: 10 points)
        $totalScore += $breakdown['timing'] = $this->getTimingScore($lead->created_at);
        
        // Clamp to 0-100
        $totalScore = min(100, max(0, $totalScore));
        
        // Store breakdown
        $lead->update(['score_breakdown' => $breakdown]);
        
        return $totalScore;
    }
    
    private function isCorporateEmail(string $email): bool
    {
        $domain = explode('@', $email)[1];
        $freeEmails = ['gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com'];
        return !in_array($domain, $freeEmails);
    }
    
    private function checkEmailQuality(string $email): bool
    {
        // Check for common spam patterns
        $spamPatterns = ['nospam', 'test', 'fake', 'invalid'];
        return !preg_match('/' . implode('|', $spamPatterns) . '/i', $email);
    }
    
    private function getSourceScore(string $source): int
    {
        return match($source) {
            'referral' => 10,
            'campaign' => 8,
            'form' => 5,
            'api' => 5,
            default => 0,
        };
    }
    
    private function getTimingScore($createdAt): int
    {
        $hour = $createdAt->hour;
        // Business hours (9am-5pm) get bonus
        return ($hour >= 9 && $hour < 17) ? 10 : 0;
    }
}
```

#### LeadData DTO
```php
namespace App\Application\Lead\DTOs;

use Illuminate\Validation\ValidationException;

class LeadData
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $phone,
        public readonly ?string $company_name = null,
        public readonly ?string $job_title = null,
        public readonly ?string $notes = null,
        public readonly string $source = 'form',
        public readonly string $lead_type = 'cold',
        public readonly ?array $metadata = null,
    ) {}
    
    public static function fromRequest(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            phone: $data['phone'],
            company_name: $data['company_name'] ?? null,
            job_title: $data['job_title'] ?? null,
            notes: $data['notes'] ?? null,
            source: $data['source'] ?? 'form',
            lead_type: $data['lead_type'] ?? 'cold',
            metadata: $data['metadata'] ?? null,
        );
    }
    
    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'company_name' => $this->company_name,
            'job_title' => $this->job_title,
            'notes' => $this->notes,
            'source' => $this->source,
            'lead_type' => $this->lead_type,
            'metadata' => $this->metadata,
        ]);
    }
}
```

#### SendLeadToN8n Job
```php
namespace App\Application\Lead\Jobs;

use App\Domain\Lead\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendLeadToN8n implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $tries = 3;
    public $backoff = [60, 300, 900]; // 1min, 5min, 15min
    public $timeout = 30;
    
    public function __construct(
        public Lead $lead
    ) {}
    
    public function handle(): void
    {
        $response = Http::timeout(10)
            ->withHeaders([
                'X-Webhook-Signature' => $this->generateSignature(),
                'X-Webhook-ID' => config('services.n8n.webhook_id'),
                'Content-Type' => 'application/json',
            ])
            ->post(config('services.n8n.webhook_url'), $this->getPayload());
        
        if ($response->failed()) {
            Log::warning('N8n webhook returned error', [
                'status' => $response->status(),
                'body' => $response->body(),
                'lead_id' => $this->lead->id,
            ]);
            throw new \Exception('N8n webhook failed: ' . $response->status());
        }
        
        Log::info('N8n webhook sent successfully', [
            'lead_id' => $this->lead->id,
        ]);
    }
    
    public function failed(\Throwable $exception): void
    {
        Log::error('N8n webhook failed after all retries', [
            'lead_id' => $this->lead->id,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
        
        // Optionally notify admin
        // Notification::make()->title('N8n webhook failed for lead ' . $this->lead->id)->send();
    }
    
    private function getPayload(): array
    {
        return [
            'event' => 'lead.created',
            'timestamp' => now()->toIso8601String(),
            'lead' => [
                'id' => $this->lead->id,
                'name' => $this->lead->name,
                'email' => $this->lead->email,
                'phone' => $this->lead->phone,
                'company_name' => $this->lead->company_name,
                'job_title' => $this->lead->job_title,
                'status' => $this->lead->status->value,
                'score' => $this->lead->score,
                'source' => $this->lead->source,
                'notes' => $this->lead->notes,
                'created_at' => $this->lead->created_at->toIso8601String(),
            ],
        ];
    }
    
    private function generateSignature(): string
    {
        $payload = json_encode($this->getPayload());
        $secret = config('services.n8n.webhook_secret');
        return 'sha256=' . hash_hmac('sha256', $payload, $secret);
    }
}
```

### 6.3 Infrastructure Layer Implementation

#### LeadRepositoryInterface & Implementation
```php
namespace App\Infrastructure\Repositories\Contracts;

use App\Domain\Lead\Models\Lead;
use Illuminate\Pagination\Paginator;

interface LeadRepositoryInterface
{
    public function create(array $data): Lead;
    public function update(Lead $lead, array $data): Lead;
    public function delete(Lead $lead): bool;
    public function findById(int $id): ?Lead;
    public function all(): \Illuminate\Database\Eloquent\Collection;
    public function paginate(int $perPage = 15): Paginator;
    public function getByStatus(string $status): \Illuminate\Database\Eloquent\Collection;
    public function getBySource(string $source): \Illuminate\Database\Eloquent\Collection;
    public function search(string $query): \Illuminate\Database\Eloquent\Collection;
}

namespace App\Infrastructure\Repositories;

use App\Domain\Lead\Models\Lead;
use App\Infrastructure\Repositories\Contracts\LeadRepositoryInterface;
use Illuminate\Pagination\Paginator;

class EloquentLeadRepository implements LeadRepositoryInterface
{
    public function create(array $data): Lead
    {
        return Lead::create($data);
    }
    
    public function update(Lead $lead, array $data): Lead
    {
        $lead->update($data);
        return $lead->fresh();
    }
    
    public function delete(Lead $lead): bool
    {
        return (bool) $lead->delete();
    }
    
    public function findById(int $id): ?Lead
    {
        return Lead::find($id);
    }
    
    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return Lead::orderByDesc('created_at')->get();
    }
    
    public function paginate(int $perPage = 15): Paginator
    {
        return Lead::orderByDesc('created_at')->paginate($perPage);
    }
    
    public function getByStatus(string $status): \Illuminate\Database\Eloquent\Collection
    {
        return Lead::where('status', $status)->orderByDesc('created_at')->get();
    }
    
    public function getBySource(string $source): \Illuminate\Database\Eloquent\Collection
    {
        return Lead::where('source', $source)->orderByDesc('created_at')->get();
    }
    
    public function search(string $query): \Illuminate\Database\Eloquent\Collection
    {
        return Lead::where('name', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->orWhere('phone', 'like', "%$query%")
            ->orderByDesc('created_at')
            ->get();
    }
}
```

#### LeadCache Manager
```php
namespace App\Infrastructure\Cache;

use App\Domain\Lead\Models\Lead;
use Illuminate\Support\Facades\Cache;

class LeadCache
{
    private const STATS_TTL = 3600; // 1 hour
    private const LIST_TTL = 1800; // 30 minutes
    
    public function getStatistics(string $period = 'all'): array
    {
        $cacheKey = "lead_stats_{$period}";
        
        return Cache::remember($cacheKey, self::STATS_TTL, function () use ($period) {
            $query = Lead::query();
            
            if ($period !== 'all') {
                $date = match($period) {
                    'today' => now()->startOfDay(),
                    'week' => now()->startOfWeek(),
                    'month' => now()->startOfMonth(),
                    'quarter' => now()->startOfQuarter(),
                    default => null,
                };
                
                if ($date) {
                    $query->where('created_at', '>=', $date);
                }
            }
            
            return [
                'total' => $query->count(),
                'new' => $query->where('status', 'new')->count(),
                'contacted' => $query->where('status', 'contacted')->count(),
                'qualified' => $query->where('status', 'qualified')->count(),
                'won' => $query->where('status', 'won')->count(),
                'lost' => $query->where('status', 'lost')->count(),
                'archived' => $query->where('status', 'archived')->count(),
            ];
        });
    }
    
    public function getSourceDistribution(): array
    {
        return Cache::remember('lead_source_distribution', self::STATS_TTL, function () {
            return Lead::selectRaw('source, COUNT(*) as count')
                ->groupBy('source')
                ->pluck('count', 'source')
                ->toArray();
        });
    }
    
    public function getConversionMetrics(): array
    {
        return Cache::remember('lead_conversion_metrics', self::STATS_TTL, function () {
            $total = Lead::count();
            $won = Lead::where('status', 'won')->count();
            $lost = Lead::where('status', 'lost')->count();
            
            return [
                'total_leads' => $total,
                'won_leads' => $won,
                'lost_leads' => $lost,
                'conversion_rate' => $total > 0 ? ($won / $total) * 100 : 0,
                'loss_rate' => $total > 0 ? ($lost / $total) * 100 : 0,
            ];
        });
    }
    
    public function clearAll(): void
    {
        Cache::forget('lead_stats_all');
        Cache::forget('lead_stats_today');
        Cache::forget('lead_stats_week');
        Cache::forget('lead_stats_month');
        Cache::forget('lead_source_distribution');
        Cache::forget('lead_conversion_metrics');
    }
}
```

#### N8n Client
```php
namespace App\Infrastructure\External;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class N8nClient
{
    private string $baseUrl;
    private string $webhookUrl;
    private string $apiKey;
    
    public function __construct()
    {
        $this->baseUrl = config('services.n8n.base_url');
        $this->webhookUrl = config('services.n8n.webhook_url');
        $this->apiKey = config('services.n8n.api_key');
    }
    
    public function sendWebhook(array $payload): bool
    {
        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Content-Type' => 'application/json',
                ])
                ->post($this->webhookUrl, $payload);
            
            return $response->successful();
        } catch (\Exception $e) {
            Log::error('N8n webhook error', [
                'error' => $e->getMessage(),
                'payload' => $payload,
            ]);
            return false;
        }
    }
    
    public function getWorkflows(): array
    {
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
        ])->get("{$this->baseUrl}/workflows");
        
        return $response->successful() ? $response->json() : [];
    }
}
```

### 6.4 Interface Layer Implementation

#### LeadCaptureForm Livewire Component
```php
namespace App\Interfaces\Livewire\Forms;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Application\Lead\Services\LeadService;
use App\Application\Lead\DTOs\LeadData;

class LeadCaptureForm extends Component
{
    use WithFileUploads;
    
    // Form properties
    public $name = '';
    public $email = '';
    public $phone = '';
    public $company_name = '';
    public $job_title = '';
    public $notes = '';
    public $lead_source = 'form';
    
    // UI state
    public $isSubmitting = false;
    public $isSuccess = false;
    public $successMessage = '';
    
    protected $rules = [
        'name' => 'required|string|min:3|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|regex:/^[0-9\+\-\s()]{10,}$/|max:50',
        'company_name' => 'nullable|string|max:255',
        'job_title' => 'nullable|string|max:255',
        'notes' => 'nullable|string|max:2000',
        'lead_source' => 'required|in:form,referral,campaign,manual,import,api',
    ];
    
    protected $messages = [
        'name.required' => 'Please enter your full name',
        'name.min' => 'Name must be at least 3 characters',
        'email.required' => 'Email address is required',
        'email.email' => 'Please enter a valid email address',
        'phone.required' => 'Phone number is required',
        'phone.regex' => 'Please enter a valid phone number',
    ];
    
    public function updatedEmail()
    {
        // Real-time email validation
        $this->validateOnly('email');
    }
    
    public function submit(LeadService $service)
    {
        $this->isSubmitting = true;
        
        $validated = $this->validate();
        
        try {
            $data = LeadData::fromRequest($validated);
            $lead = $service->createLead($data);
            
            $this->isSuccess = true;
            $this->successMessage = "Thank you! We've received your information. Your lead ID is: {$lead->id}";
            
            // Reset form
            $this->reset(['name', 'email', 'phone', 'company_name', 'job_title', 'notes']);
            
            // Redirect after 2 seconds
            $this->dispatch('formSubmitted', leadId: $lead->id);
            
        } catch (\Exception $e) {
            $this->addError('submit', 'An error occurred. Please try again later.');
            \Log::error('Lead submission error', ['error' => $e->getMessage()]);
        } finally {
            $this->isSubmitting = false;
        }
    }
    
    public function render()
    {
        return view('livewire.forms.lead-capture-form');
    }
}
```

#### LeadResource (Filament)
```php
namespace App\Interfaces\Filament\Resources;

use App\Domain\Lead\Models\Lead;
use App\Domain\Lead\Enums\LeadStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Leads';
    protected static ?int $navigationSort = 1;
    protected static ?string $pluralModelLabel = 'Leads';
    
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Contact Information')
                ->description('Core lead information')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Full name')
                        ->columnSpan(2),
                    
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->placeholder('email@example.com'),
                    
                    Forms\Components\TextInput::make('phone')
                        ->tel()
                        ->required()
                        ->maxLength(50)
                        ->placeholder('+1 (555) 000-0000'),
                    
                    Forms\Components\TextInput::make('company_name')
                        ->maxLength(255)
                        ->placeholder('Company name'),
                    
                    Forms\Components\TextInput::make('job_title')
                        ->maxLength(255)
                        ->placeholder('Job title'),
                ])
                ->columns(2),
            
            Forms\Components\Section::make('Lead Status & Scoring')
                ->description('Management details')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->options([
                            'new' => 'New',
                            'contacted' => 'Contacted',
                            'qualified' => 'Qualified',
                            'won' => 'Won',
                            'lost' => 'Lost',
                            'archived' => 'Archived',
                        ])
                        ->default('new')
                        ->required(),
                    
                    Forms\Components\Select::make('source')
                        ->options([
                            'form' => 'Website Form',
                            'referral' => 'Referral',
                            'campaign' => 'Campaign',
                            'manual' => 'Manual Entry',
                            'import' => 'Import',
                            'api' => 'API',
                        ])
                        ->default('form'),
                    
                    Forms\Components\TextInput::make('score')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->suffix('points'),
                    
                    Forms\Components\Select::make('lead_type')
                        ->options([
                            'cold' => 'Cold',
                            'warm' => 'Warm',
                            'hot' => 'Hot',
                            'customer' => 'Customer',
                        ]),
                ])
                ->columns(2),
            
            Forms\Components\Section::make('Additional Information')
                ->schema([
                    Forms\Components\Select::make('assigned_to')
                        ->relationship('assignedUser', 'name')
                        ->searchable()
                        ->preload()
                        ->placeholder('Unassigned'),
                    
                    Forms\Components\TextInput::make('estimated_value')
                        ->numeric()
                        ->prefix('$')
                        ->step('0.01'),
                    
                    Forms\Components\TextInput::make('probability_percentage')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->suffix('%'),
                    
                    Forms\Components\Textarea::make('notes')
                        ->rows(3)
                        ->columnSpan(2),
                    
                    Forms\Components\Textarea::make('internal_comments')
                        ->rows(3)
                        ->columnSpan(2)
                        ->label('Internal Notes'),
                ])
                ->columns(2),
        ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->url(fn (Lead $record) => static::getUrl('edit', ['record' => $record])),
                
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-o-envelope')
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->icon('heroicon-o-phone')
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('company_name')
                    ->searchable()
                    ->toggleable(),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->getStateUsing(fn (Lead $record) => $record->status->label())
                    ->colors([
                        'success' => 'won',
                        'warning' => 'contacted',
                        'danger' => 'lost',
                        'info' => 'new',
                    ])
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('score')
                    ->numeric()
                    ->sortable()
                    ->suffix(' pts')
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('assignedUser.name')
                    ->label('Assigned To')
                    ->default('Unassigned')
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'contacted' => 'Contacted',
                        'qualified' => 'Qualified',
                        'won' => 'Won',
                        'lost' => 'Lost',
                        'archived' => 'Archived',
                    ])
                    ->multiple(),
                
                Tables\Filters\SelectFilter::make('source')
                    ->options([
                        'form' => 'Form',
                        'referral' => 'Referral',
                        'campaign' => 'Campaign',
                    ])
                    ->multiple(),
                
                Tables\Filters\Filter::make('score')
                    ->form([
                        Forms\Components\TextInput::make('score_min')
                            ->numeric()
                            ->label('Minimum Score'),
                    ])
                    ->query(fn ($query, $data) => $query->where('score', '>=', $data['score_min'] ?? 0)),
            ])
            ->actions([
                Tables\Actions\Action::make('qualify')
                    ->label('Qualify')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->action(function (Lead $record) {
                        $record->qualify();
                        Notification::make()
                            ->title('Lead qualified successfully')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Lead $record) => $record->status !== LeadStatus::QUALIFIED),
                
                Tables\Actions\Action::make('markWon')
                    ->label('Mark as Won')
                    ->icon('heroicon-o-sparkles')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Lead $record) {
                        $record->markAsWon();
                        Notification::make()
                            ->title('Lead marked as won')
                            ->success()
                            ->send();
                    }),
                
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('changeStatus')
                        ->label('Change Status')
                        ->icon('heroicon-o-arrow-path')
                        ->form([
                            Forms\Components\Select::make('status')
                                ->options([
                                    'contacted' => 'Contacted',
                                    'qualified' => 'Qualified',
                                    'won' => 'Won',
                                    'lost' => 'Lost',
                                ])
                                ->required(),
                        ])
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records, array $data) {
                            $records->each->update(['status' => $data['status']]);
                        }),
                    
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => \App\Interfaces\Filament\Resources\LeadResource\Pages\ListLeads::route('/'),
            'create' => \App\Interfaces\Filament\Resources\LeadResource\Pages\CreateLead::route('/create'),
            'edit' => \App\Interfaces\Filament\Resources\LeadResource\Pages\EditLead::route('/{record}/edit'),
        ];
    }
}
```

---

## 7. Scalability & Performance Requirements

### 7.1 Performance Targets

| Metric | Target | Notes |
|--------|--------|-------|
| Homepage Load | < 2s | First contentful paint |
| Form Load | < 1.5s | Livewire component initialization |
| Form Submission | < 500ms | Server processing |
| Lead List (50 items) | < 1s | Dashboard initial load |
| Dashboard Stats | < 800ms | Cached results |
| Search Query | < 2s | Full-text search on 100K+ leads |
| API Response | < 200ms | JSON endpoint |
| Database Query | < 100ms | Single query (99th percentile) |

### 7.2 Scalability Considerations

#### Database Optimization
- **Indexes**: Composite indexes on frequently queried columns
- **Partitioning**: Partition leads by date for large datasets
- **Archiving**: Archive leads older than 2 years
- **Query Optimization**: Eager loading with `with()`
- **Read Replicas**: Setup for heavy read operations

#### Caching Strategy
- Redis for session storage
- Query result caching (1-24 hours based on data)
- HTTP caching headers
- CDN for static assets
- Browser caching for JS/CSS

#### Load Balancing
- Horizontal scaling with multiple app servers
- Load balancer (nginx/HAProxy)
- Session sticky connections (Redis-based)
- Database connection pooling

#### Job Queue Optimization
- Use Redis for queue backend
- Multiple queue workers
- Job rate limiting
- Dead letter queue for failed jobs
- Monitoring and alerting

### 7.3 Monitoring & Observability

**Metrics to Track:**
- Request response time (p50, p95, p99)
- Database query performance
- Queue processing time
- Cache hit rate
- Error rates by endpoint
- Active concurrent users
- Memory usage
- CPU usage
- Disk I/O

**Logging:**
- Request/response logging
- Slow query logging (> 500ms)
- Failed job logging
- User activity logging
- Error tracking with Sentry/equivalent

---

## 8. Security Requirements

### 8.1 Authentication & Authorization
- [ ] Bcrypt password hashing (Laravel default)
- [ ] CSRF token on all forms
- [ ] Rate limiting (5 attempts per 15 minutes for login)
- [ ] Session timeout (30 minutes)
- [ ] Two-factor authentication (optional but recommended)
- [ ] Role-based access control (RBAC)

### 8.2 Data Protection
- [ ] Input validation and sanitization
- [ ] SQL injection prevention (use parameterized queries)
- [ ] XSS prevention (escape output)
- [ ] CORS properly configured
- [ ] HTTPS enforced
- [ ] SSL/TLS certificate

### 8.3 Data Privacy
- [ ] PII encryption at rest
- [ ] PII masked in logs
- [ ] GDPR compliance (data export, deletion)
- [ ] Privacy policy
- [ ] Cookie consent
- [ ] Data retention policy (delete after X years)

### 8.4 Infrastructure Security
- [ ] Firewall rules
- [ ] DDoS protection
- [ ] WAF (Web Application Firewall)
- [ ] Regular security patches
- [ ] Vulnerability scanning
- [ ] Penetration testing (quarterly)
- [ ] Incident response plan

---

## 9. Deployment & DevOps

### 9.1 Development Environment
```bash
# Requirements
- PHP 8.4+
- Composer
- Node.js 18+
- npm/yarn
- MySQL 8.0+
- Redis
- Docker & Docker Compose

# Setup
git clone <repository>
cd lead-management-system
cp .env.example .env
composer install
npm install
php artisan key:generate
php artisan migrate --seed
npm run dev
php artisan serve
```

### 9.2 Production Deployment
**Infrastructure:**
- VPS or Cloud (AWS, DigitalOcean, Heroku)
- CDN for static assets (Cloudflare)
- Database backups (daily)
- Database replication (master-slave)
- Email service (SendGrid, Mailgun)
- Monitoring (New Relic, Datadog)

**Process:**
1. Push to main branch
2. GitHub Actions runs tests
3. Auto-deploy to production
4. Database migrations run
5. Cache cleared
6. Notifications sent

### 9.3 Docker Configuration
```dockerfile
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    mysql-client \
    libpq-dev \
    redis-tools \
    supervisor

# Copy application
COPY . /app
WORKDIR /app

# Install composer dependencies
RUN composer install --no-dev

# Run migrations
RUN php artisan migrate --force

# Set permissions
RUN chown -R www-data:www-data /app

EXPOSE 9000
CMD ["php-fpm"]
```

---

## 10. Testing Requirements

### 10.1 Test Coverage
- Unit Tests: 80%+ coverage for services and models
- Feature Tests: 90%+ coverage for critical paths
- Integration Tests: All external integrations
- Performance Tests: Load testing

### 10.2 Test Suites

#### Unit Tests
```php
// Tests/Unit/LeadScoringServiceTest.php
- Test score calculation logic
- Test qualifying logic
- Test edge cases
```

#### Feature Tests
```php
// Tests/Feature/LeadCreationTest.php
- Test lead creation via form
- Test validation rules
- Test email confirmation
- Test N8n webhook dispatch

// Tests/Feature/LeadManagementTest.php
- Test CRUD operations
- Test status transitions
- Test filtering and searching
- Test assignment logic
```

#### Integration Tests
```php
// Tests/Integration/N8nWebhookTest.php
- Test webhook payload
- Test retry mechanism
- Test signature verification
```

### 10.3 Testing Commands
```bash
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage

# Run specific test file
php artisan test tests/Feature/LeadCreationTest.php

# Run performance tests
php artisan test tests/Performance/

# Watch tests
php artisan test --watch
```

---

## 11. Documentation Requirements

### 11.1 Code Documentation
- [ ] PHPDoc blocks for all public methods
- [ ] Inline comments for complex logic
- [ ] README with setup instructions
- [ ] API documentation (webhook format)
- [ ] Architecture documentation

### 11.2 User Documentation
- [ ] Admin user guide
- [ ] Form integration guide
- [ ] API reference
- [ ] FAQ section
- [ ] Troubleshooting guide

### 11.3 Developer Documentation
- [ ] Development setup guide
- [ ] Contributing guidelines
- [ ] Code style guide (PSR-12)
- [ ] Git workflow
- [ ] Deployment guide

---

## 12. Configuration Files

### 12.1 Environment Variables (.env)
```
APP_NAME="Lead Management System"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://leads.example.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lead_system
DB_USERNAME=root
DB_PASSWORD=

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@leadsystem.com
MAIL_FROM_NAME="Lead System"

N8N_BASE_URL=https://n8n.example.com
N8N_WEBHOOK_URL=https://n8n.example.com/webhook/lead
N8N_WEBHOOK_ID=lead-webhook-123
N8N_WEBHOOK_SECRET=super-secret-key-here
N8N_API_KEY=

FILAMENT_ADMIN_PATH=admin
FILAMENT_ADMIN_DOMAIN=

LOG_CHANNEL=stack
LOG_LEVEL=debug
```

### 12.2 Services Configuration (config/services.php)
```php
return [
    'n8n' => [
        'base_url' => env('N8N_BASE_URL'),
        'webhook_url' => env('N8N_WEBHOOK_URL'),
        'webhook_id' => env('N8N_WEBHOOK_ID'),
        'webhook_secret' => env('N8N_WEBHOOK_SECRET'),
        'api_key' => env('N8N_API_KEY'),
    ],
    
    'mail' => [
        'driver' => env('MAIL_MAILER', 'smtp'),
        'host' => env('MAIL_HOST'),
        'port' => env('MAIL_PORT'),
        'from' => [
            'address' => env('MAIL_FROM_ADDRESS'),
            'name' => env('MAIL_FROM_NAME'),
        ],
    ],
];
```

---

## 13. Success Criteria & Acceptance

### 13.1 Functional Requirements
-  Lead capture form working without errors
-  Admin dashboard displaying all leads
-  CRUD operations functional
-  Status management workflow operational
-  Lead scoring system calculating correctly
-  N8n webhook integration working
-  Email notifications sending
-  Dashboard widgets displaying real-time data
-  Filtering and searching working
-  User management operational

### 13.2 Non-Functional Requirements
-  Response time < 500ms for lead creation
-  99.9% uptime
-  Load handling 1000 concurrent users
-  Database queries optimized
-  Code coverage > 80%
-  Security scan passes
-  OWASP compliance
-  Responsive on all devices
-  Accessibility (WCAG 2.1 Level AA)
-  Performance score > 90 (Lighthouse)

### 13.3 Quality Gates
-  All tests passing
-  No critical bugs
-  Code review approved
-  Documentation complete
-  Security audit passed
-  Performance benchmarks met

---

## 14. Maintenance & Support

### 14.1 Ongoing Maintenance
- Monthly security patches
- Quarterly dependency updates
- Semi-annual full audit
- Daily automated backups
- Weekly log review

### 14.2 Support Plan
- Critical bugs: 4-hour response
- Major bugs: 24-hour response
- Feature requests: 1-week review
- Email support: 24-hour response time
- Monitoring: 24/7 automated

---


**DOCUMENT END**

*This PRD covers all technical requirements, frontend specifications, backend architecture, scalability considerations, and deployment strategy for the Lead Management System project.*
