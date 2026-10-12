@extends('frontend.pages.static.layout')

@section('title', 'US Holiday Calendar')
@section('meta_title', 'US Holiday Calendar: Are Banks, Post Offices & the Stock Market Open? | Big Times News')
@section('meta_description', 'Upcoming US federal holidays with dates and whether banks, the post office and the stock market are open or closed.')
@section('meta_keywords', 'US holidays, bank holidays, stock market holidays, post office closed, federal holidays')
@section('crumb', 'US Holiday Calendar')
@section('heading', 'US Holiday Calendar')
@section('lead', 'Upcoming US holidays and whether banks, the post office and the stock market are open.')

@section('page_css')
<style>
    .static-page .hc-wrap { overflow-x: auto; margin: 1.25rem 0 1rem; border: 1px solid var(--sp-border); border-radius: 12px; -webkit-overflow-scrolling: touch; }
    .static-page .hc-table { width: 100%; min-width: 720px; border-collapse: separate; border-spacing: 0; font-size: .95rem; line-height: 1.4; }
    .static-page .hc-table thead th { position: sticky; top: 0; background: var(--sp-soft); color: var(--sp-head); text-align: left; font-weight: 700; font-size: .8rem; text-transform: uppercase; letter-spacing: .04em; padding: .85rem 1rem; border-bottom: 1px solid var(--sp-border); white-space: nowrap; }
    .static-page .hc-table td { padding: .8rem 1rem; color: var(--sp-text); border-bottom: 1px solid var(--sp-border); vertical-align: top; }
    .static-page .hc-table tbody tr:last-child td { border-bottom: 0; }
    .static-page .hc-table tbody tr.hc-row:hover td { background: var(--sp-soft); }
    .static-page .hc-name { font-weight: 600; color: var(--sp-head); min-width: 160px; }
    .static-page .hc-date { white-space: nowrap; color: var(--sp-head); }
    .static-page .hc-year { display: block; font-size: .8rem; color: var(--sp-muted); }
    .static-page .hc-pill { display: inline-block; padding: .2rem .6rem; border-radius: 999px; font-size: .82rem; font-weight: 600; line-height: 1.3; }
    .static-page .hc-closed { background: #fee2e2; color: #991b1b; }
    .static-page .hc-open { background: #dcfce7; color: #166534; }
    .static-page .hc-check { background: #fef3c7; color: #92400e; }
    html.uc-dark .static-page .hc-closed { background: rgba(239,68,68,.18); color: #fca5a5; }
    html.uc-dark .static-page .hc-open { background: rgba(34,197,94,.18); color: #86efac; }
    html.uc-dark .static-page .hc-check { background: rgba(245,158,11,.18); color: #fcd34d; }
    .static-page .hc-table tr.hc-note td { padding-top: 0; font-size: .85rem; color: var(--sp-muted); }
    .static-page .hc-table tr.hc-row.has-note td { border-bottom: 0; }
    .static-page .hc-legend { display: flex; flex-wrap: wrap; gap: .5rem 1rem; font-size: .85rem; color: var(--sp-muted); margin-bottom: .5rem; }
    .static-page .hc-disclaimer { font-size: .85rem; color: var(--sp-muted); }
    @media (max-width: 640px) { .static-page .hc-table { font-size: .9rem; } .static-page .hc-table td, .static-page .hc-table thead th { padding: .65rem .75rem; } }
</style>
@endsection



@section('page_body')
@php
    $pill = function ($text) {
        $t = strtolower($text);
        $cls = str_starts_with($t, 'closed') ? 'hc-closed' : (str_starts_with($t, 'open') ? 'hc-open' : 'hc-check');
        return '<span class="hc-pill ' . $cls . '">' . e($text) . '</span>';
    };
@endphp
    <p>Quick reference for the next holidays. Where a holiday falls on a weekend, observed dates can vary by institution, so we say "Check locally" when it is not certain.</p>

    <div class="hc-legend">
        <span><span class="hc-pill hc-open">Open</span></span>
        <span><span class="hc-pill hc-closed">Closed</span></span>
        <span><span class="hc-pill hc-check">Check locally</span></span>
    </div>

    <div class="hc-wrap">
    <table class="hc-table">
        <thead>
            <tr><th>Holiday</th><th>Date</th><th>Banks</th><th>Post Office</th><th>Stock Market</th></tr>
        </thead>
        <tbody>
        @foreach ($rows as $r)
            <tr class="hc-row {{ !empty($r['note']) ? 'has-note' : '' }}">
                <td class="hc-name">{{ $r['name'] }}</td>
                <td class="hc-date">{{ $r['date']->format('D, M j') }}<span class="hc-year">{{ $r['date']->format('Y') }}</span></td>
                <td>{!! $pill($r['banks']) !!}</td>
                <td>{!! $pill($r['post']) !!}</td>
                <td>{!! $pill($r['market']) !!}</td>
            </tr>
            @if (!empty($r['note']))
            <tr class="hc-note"><td colspan="5">{{ $r['note'] }}</td></tr>
            @endif
        @endforeach
        </tbody>
    </table>
    </div>
    <p class="hc-disclaimer">Banks = Federal Reserve schedule. Stock market = NYSE and Nasdaq. Always confirm with your bank, local post office or the NYSE for official schedules.</p>
@endsection