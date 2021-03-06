/*
 * Generated by asn1c-0.9.27 (http://lionet.info/asn1c)
 * From ASN.1 module "DSRC"
 * 	found in "../J2735_R41_Source_mod.ASN"
 * 	`asn1c -gen-PER -fcompound-names -fincludes-quoted`
 */

#ifndef	_AdvisorySpeed_H_
#define	_AdvisorySpeed_H_


#include "asn_application.h"

/* Including external dependencies */
#include "AdvisorySpeedType.h"
#include "SpeedAdvice.h"
#include "SpeedConfidence.h"
#include "ZoneLength.h"
#include "RestrictionClassID.h"
#include "constr_SEQUENCE.h"

#ifdef __cplusplus
extern "C" {
#endif

/* Forward declarations */
struct Reg_AdvisorySpeed;

/* AdvisorySpeed */
typedef struct AdvisorySpeed {
	AdvisorySpeedType_t	 type;
	SpeedAdvice_t	*speed	/* OPTIONAL */;
	SpeedConfidence_t	*confidence	/* OPTIONAL */;
	ZoneLength_t	*distance	/* OPTIONAL */;
	RestrictionClassID_t	*Class	/* OPTIONAL */;
	struct Reg_AdvisorySpeed	*regional	/* OPTIONAL */;
	/*
	 * This type is extensible,
	 * possible extensions are below.
	 */
	
	/* Context for parsing across buffer boundaries */
	asn_struct_ctx_t _asn_ctx;
} AdvisorySpeed_t;

/* Implementation */
extern asn_TYPE_descriptor_t asn_DEF_AdvisorySpeed;

#ifdef __cplusplus
}
#endif

/* Referred external types */
#include "RegionalAdvisorySpeed.h"

#endif	/* _AdvisorySpeed_H_ */
#include "asn_internal.h"
