<?php

namespace InvestecSdkPhp\Enumerations;

enum BopReportType: string
{
    case ALL = 'all';
    case NEW = 'New';
    case INCOMPLETE = 'Incomplete';
    case DOCS_REQUIRED = 'DocsRequired';
    case DOCS_RECEIVED = 'DocsReceived';
    case COMPLETED = 'Completed';
    case CANCELLED = 'Cancelled';
}
