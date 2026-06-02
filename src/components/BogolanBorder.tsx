import React from 'react';

interface BogolanBorderProps {
  className?: string;
  horizontal?: boolean;
}

export default function BogolanBorder({ className = '', horizontal = true }: BogolanBorderProps) {
  if (horizontal) {
    return (
      <div className={`w-full h-3 flex overflow-hidden select-none opacity-80 ${className}`}>
        {Array.from({ length: 40 }).map((_, i) => (
          <div key={i} className="flex-shrink-0 flex h-full">
            <span className="w-2 h-full bg-brand-red"></span>
            <span className="w-1 h-full bg-brand-gold"></span>
            <span className="w-2 h-full bg-brand-charcoal flex items-center justify-center text-[5px] text-brand-cream font-mono">▲</span>
            <span className="w-1 h-full bg-brand-green"></span>
            <span className="w-1 h-full bg-brand-cream"></span>
            <span className="w-2 h-full bg-brand-charcoal flex items-center justify-center text-[5px] text-brand-cream font-mono">▼</span>
          </div>
        ))}
      </div>
    );
  }

  return (
    <div className={`h-full w-3 flex flex-col overflow-hidden select-none opacity-80 ${className}`}>
      {Array.from({ length: 40 }).map((_, i) => (
        <div key={i} className="flex-shrink-0 flex flex-col w-full">
          <span className="h-2 w-full bg-brand-red"></span>
          <span className="h-1 w-full bg-brand-gold"></span>
          <span className="h-2 w-full bg-brand-charcoal flex items-center justify-center text-[5px] text-brand-cream font-mono">◀</span>
          <span className="h-1 w-full bg-brand-green"></span>
          <span className="h-1 w-full bg-brand-cream"></span>
          <span className="h-2 w-full bg-brand-charcoal flex items-center justify-center text-[5px] text-brand-cream font-mono">▶</span>
        </div>
      ))}
    </div>
  );
}
